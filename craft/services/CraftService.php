<?php

namespace common\craft\services;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use ss\core\Core;
use yii\helpers\ArrayHelper;
use ss\core\BaseService;
use common\helpers\DbHelper;
use common\models\user\UserAccount;
use common\models\billing\Currency;
use common\models\billing\Transaction;
use common\models\billing\Wallet;
use common\craft\models\CraftRecipe;
use common\craft\models\CraftRecipeQuery;
use common\craft\recipes\Recipes;
use common\craft\recipes\LootComponent;
use common\craft\recipes\MoneyComponent;
use common\inventory\items\LootItem;
use common\inventory\helpers\InventoryHelper;
use common\inventory\services\InventoryService;

class CraftService extends BaseService
{
    private InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService, $config = [])
    {
        parent::__construct($config);

        $this->inventoryService = $inventoryService;
    }

    public static function getRarityExploring(): array
    {
        return [
            Recipes::RARITY_SIMPLE => '10 minutes',
            Recipes::RARITY_UNUSUAL => '1 hour',
            Recipes::RARITY_RARE => '3 hours',
            Recipes::RARITY_EPIC => '10 hours',
            Recipes::RARITY_LEGENDARY => '24 hours',
        ];
    }

    public static function getIntervalExploring(UserAccount $user, string $rarity): CarbonInterval
    {
        $duration = ArrayHelper::getValue(CraftService::getRarityExploring(), $rarity);
        $interval = CarbonInterval::parseFromLocale($duration);

        if ($user->checkSubscription()) {
            if ($user->subscription_type === UserAccount::SUBSCRIPTION_TYPE_HERO) {
                $interval = CarbonInterval::seconds($interval->totalSeconds / 2);
            } elseif ($user->subscription_type === UserAccount::SUBSCRIPTION_TYPE_MASTER) {
                $interval = CarbonInterval::seconds(0);
            }
        }

        return $interval;
    }

    public function syncRecipes(UserAccount $user)
    {
        DbHelper::ensureTransaction();

        $recipes = $this->getBaseQuery($user->id)->indexBy('recipe_id')->all();

        $defaultIds = Recipes::getDefaultIds();

        foreach ($defaultIds as $id) {
            $recipe = ArrayHelper::getValue($recipes, $id);

            if ($recipe === null) {
                $this->createRecipe($user, $id);
            }
        }

        foreach ($recipes as $recipe) {
            if ($recipe->isStatusExploring()) {
                $this->stopExploringRecipe($recipe);
            }
        }
    }

    public function addRecipe(UserAccount $user, string $id): CraftRecipe
    {
        DbHelper::ensureTransaction();

        if (!in_array($id, Recipes::getIDs())) {
            throw new \LogicException("Invalid recipe ID {$id}.");
        }

        $recipe = $this->findRecipe($user->id, $id);

        if ($recipe) {
            throw new \LogicException("Recipe {$id} already exist.");
        }

        $recipe = new CraftRecipe();
        $recipe->recipe_id = $id;
        $recipe->user_id = $user->id;
        $recipe->status = CraftRecipe::STATUS_REGISTERED;
        $recipe->trySave(false);

        return $recipe;
    }

    public function stopExploringRecipe(CraftRecipe $recipe)
    {
        $isExpired = $recipe->isExploringExpired();

        if (!$isExpired) {
            return;
        }

        $recipe->status = CraftRecipe::STATUS_EXPLORED;
        $recipe->explore_started_at = null;
        $recipe->explore_finished_at = null;
        $recipe->tryUpdate(false);
        $recipe->refresh();
    }

    public function exploreRecipe(CraftRecipe $recipe): CraftRecipe
    {
        DbHelper::ensureTransaction();

        if (!$recipe->isStatusRegistered()) {
            throw new \LogicException("Invalid status.");
        }

        $now = Carbon::now('utc');

        $user = $recipe->user;
        $recipeType = Recipes::create($recipe->recipe_id);
        $price = $recipeType->getPrice();
        $currency = $price->getCurrency()->getCode();

        $wallet = $this->getWalletByCurrency($user, $currency);

        if ($wallet->balance->lessThan($price)) {
            throw new \LogicException("Not enough {$currency}.");
        }

        $root = UserAccount::findOne(Core::ROOT_USER_ID);
        $rootWallet = $root->getWallet($wallet->type, $wallet->currency_code);

        $wallet->transfer(
            $rootWallet,
            $price,
            Transaction::TYPE_CRAFT_EXPLORE,
            "Explore recipe",
        );

        $interval = CraftService::getIntervalExploring($user, $recipeType->getRarity());

        if ($interval->isEmpty()) {
            $recipe->status = CraftRecipe::STATUS_EXPLORED;
        } else {
            $exploreStartedAt = $now->clone();
            $exploreFinishedAt = $now->clone()->add($interval);

            $recipe->status = CraftRecipe::STATUS_EXPLORING;
            $recipe->explore_started_at = $exploreStartedAt->toDateTimeString();
            $recipe->explore_finished_at = $exploreFinishedAt->toDateTimeString();
        }

        $recipe->tryUpdate(false);
        $recipe->refresh();

        return $recipe;
    }

    public function craftRecipe(CraftRecipe $recipe): CraftRecipe
    {
        DbHelper::ensureTransaction();

        if (!$recipe->isStatusExplored()) {
            throw new \LogicException("Invalid status.");
        }

        $user = $recipe->user;
        $recipeType = Recipes::create($recipe->recipe_id);

        if (empty($recipeType->getComponents())) {
            throw new \LogicException("Object creation failed.");
        }

        foreach ($recipeType->getComponents() as $component) {
            if ($component instanceof LootComponent) {
                $loot = $component->getObject();
                $itemType = new LootItem($loot);

                $item = $this->inventoryService->findItem($user, $itemType);

                if ($item === null) {
                    throw new \LogicException("Not enough loot volume.");
                }

                if ($item->total_volume < $loot->getVolume()) {
                    throw new \LogicException("Not enough loot volume.");
                }

                $this->inventoryService->spend($user, $itemType, $loot->getVolume());
            }

            if ($component instanceof MoneyComponent) {
                $amount = $component->getObject();
                $currency = $amount->getCurrency()->getCode();

                $wallet = $this->getWalletByCurrency($user, $currency);

                if ($wallet->balance->lessThan($amount)) {
                    throw new \LogicException("Not enough {$currency}.");
                }

                $root = UserAccount::findOne(Core::ROOT_USER_ID);
                $rootWallet = $root->getWallet($wallet->type, $wallet->currency_code);

                $wallet->transfer(
                    $rootWallet,
                    $amount,
                    Transaction::TYPE_CRAFT_CREATE,
                    "Create by recipe",
                );
            }
        }

        $loot = $recipeType->getObject();
        $itemType = new LootItem($loot);

        $item = $this->inventoryService->findItem($user, $itemType);

        if ($item === null) {
            if (!InventoryHelper::hasFreeCells($user)) {
                throw new \LogicException("Inventory is full.");
            }
        }

        $this->inventoryService->add($user, $itemType);

        return $recipe;
    }

    private function getWalletByCurrency(UserAccount $user, string $currency): Wallet
    {
        $walletMap = [
            Currency::DUST => ['type' => Wallet::TYPE_DUST, 'currency' => Currency::DUST],
            Currency::QRK => ['type' => Wallet::TYPE_QRK, 'currency' => Currency::QRK],
        ];
        $walletOpts = ArrayHelper::getValue($walletMap, $currency);

        return $user->getWallet($walletOpts['type'], $walletOpts['currency']);
    }

    private function createRecipe(UserAccount $user, string $id): CraftRecipe
    {
        $recipe = new CraftRecipe();
        $recipe->recipe_id = $id;
        $recipe->user_id = $user->id;
        $recipe->status = CraftRecipe::STATUS_REGISTERED;
        $recipe->trySave(false);

        return $recipe;
    }

    private function findRecipe(int $userId, string $id): ?CraftRecipe
    {
        return $this->getBaseQuery($userId)->byRecipeId($id)->one();
    }

    private function getBaseQuery(int $userId): CraftRecipeQuery
    {
        return CraftRecipe::find()->byUser($userId);
    }
}