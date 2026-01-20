<?php

namespace common\box\services;

use __;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use ss\core\BaseService;
use common\models\user\UserAccount;
use common\box\BoxInterface;
use common\box\BoxTypes;
use common\box\prizes\BoxPrizes;
use common\box\prizes\PrizeInterface;
use common\box\prizes\AutoBotPrize;
use common\box\prizes\HeroPrize;
use common\box\types\MegaBox;
use common\box\events\BoxOpenedEvent;
use common\helpers\DbHelper;
use common\helpers\RandomHelper;
use common\prizeRegister\models\PrizeRegister;
use common\prizeRegister\services\PrizeRegisterService;
use common\inventory\helpers\InventoryHelper;
use common\inventory\items\Items;
use common\inventory\models\Inventory;
use common\inventory\services\InventoryService;
use common\autobot\services\AutoBotService;

class BoxService extends BaseService
{
    private InventoryService $inventoryService;
    private PrizeRegisterService $registerService;
    private AutoBotService $autoBotService;

    public function __construct(InventoryService $inventoryService, PrizeRegisterService $registerService, AutoBotService $autoBotService, $config = [])
    {
        parent::__construct($config);

        $this->inventoryService = $inventoryService;
        $this->registerService = $registerService;
        $this->autoBotService = $autoBotService;
    }

    /**
     * @param Inventory $item
     * @return PrizeInterface[]
     */
    public function open(Inventory $item): array
    {
        DbHelper::ensureTransaction();

        if (!$this->canOpen($item)) {
            throw new \LogicException("The box cannot be opened.");
        }

        $user = $item->user;

        $box = BoxTypes::create($item->type_id);

        $prizes = match ($box->getType()) {
            BoxTypes::TYPE_BASIC => $this->handleBasicPrizes($item),
            BoxTypes::TYPE_RARE => $this->handleRarePrizes($item),
            BoxTypes::TYPE_MEGA => $this->handleMegaPrizes($item),
            default => throw new \LogicException("Invalid box type."),
        };

        $this->inventoryService->delete($user, $item->id, false);

        Event::trigger(BoxOpenedEvent::class, BoxOpenedEvent::EVENT_OPENED, BoxOpenedEvent::obtain($user, $box, $prizes));

        foreach ($prizes as $prize) {
            $this->registerService->register($user, $prize->getId(), PrizeRegister::SOURCE_BOX, $box->getType());
        }

        return $prizes;
    }

    // 2 приза
    private function handleBasicPrizes(Inventory $item): array
    {
        $prizes = [];

        $user = $item->user;
        $box = BoxTypes::create($item->type_id);

        $moneyPrize = $this->generateMoneyPrize($user, $box);
        $prizes[] = $moneyPrize;

        $mainPrize = $this->generatePrize($user, $box);

        if ($mainPrize) {
            $prizes[] = $mainPrize;
        }

        return $prizes;
    }

    // 1 приз
    private function handleRarePrizes(Inventory $item): array
    {
        $prizes = [];

        $user = $item->user;
        $box = BoxTypes::create($item->type_id);

        $mainPrize = $this->generatePrize($user, $box);

        if ($mainPrize) {
            $prizes[] = $mainPrize;
        }

        return $prizes;
    }

    // 2 или 3 приза
    private function handleMegaPrizes(Inventory $item): array
    {
        $user = $item->user;
        $box = BoxTypes::create($item->type_id);

        $filterPrizes = fn(array $prizes, array $availablePrizes): array => array_values(array_intersect($prizes, $availablePrizes));

        // 1 обязательный приз
        $firstPrize = BoxPrizes::createById($user, $box, BoxPrizes::ID_MONEY_QRK);
        $prizes[] = $firstPrize;

        // 2 обязательный приз
        $secondPrizeIds = [
            // equipments
            BoxPrizes::ID_LOOT_EQUIPMENT_SHIELD_GUARDIAN_GARDENS,

            // potions
            BoxPrizes::ID_LOOT_POTION_OIL_QUARK,

            // materials
            BoxPrizes::ID_LOOT_MATERIAL_SHARD_QUARK,
            BoxPrizes::ID_LOOT_MATERIAL_SHARD_FLUR,

            // relics
            BoxPrizes::ID_LOOT_RELIC_TABLET_RUSTED,
            BoxPrizes::ID_LOOT_RELIC_LAMP_KEROSENE,

            // upgrades
            BoxPrizes::ID_UPGRADE_DRILL_HASHRATE,
            BoxPrizes::ID_UPGRADE_DRILL_HASHRATE_HALLOWEEN,

            // boxes
            BoxPrizes::ID_BOX_RARE,
        ];
        $secondPrize = $this->generatePrize($user, $box, fn(array $prizes) => $filterPrizes($prizes, $secondPrizeIds));
        $prizes[] = $secondPrize;

        // 3 необязательный приз
        $isLucky = $this->rollChance(80);

        if ($isLucky) {
            $thirdPrize = $this->generatePrize($user, $box, fn(array $prizes) => $filterPrizes($prizes, MegaBox::getFilterPrizes()));

            if ($thirdPrize) {
                $prizes[] = $thirdPrize;
            }
        }

        return $prizes;
    }

    private function canOpen(Inventory $item): bool
    {
        if ($item->type <> Items::TYPE_BOX) {
            return false;
        }

        if (!InventoryHelper::hasFreeCells($item->user)) {
            return false;
        }

        return true;
    }

    private function rollChance(int|float $probability): int
    {
        if ($probability < 0 || $probability > 100) {
            throw new \InvalidArgumentException('Probability must be between 0 and 100');
        }

        return rand(1, 100) <= $probability ? 1 : 0;
    }

    private function generatePrize(UserAccount $user, BoxInterface $box, callable $prizeFilter = null): ?PrizeInterface
    {
        $defaultPrizeId = $box::getDefaultPrizeId();

        $prizeId = $this->generateRandomPrize($box, $prizeFilter);

        if ($prizeId === null) {
            $prizeId = $defaultPrizeId;
        }

        $prize = BoxPrizes::createById($user, $box, $prizeId);

        if ($prize instanceof HeroPrize) {
            $heroConfig = $prize->getObject();
            $existHero = $user->getHeroById($heroConfig->getID()) !== null;

            if ($existHero) {
                $heroConfig = $box::getConfigPrizes()[BoxPrizes::TYPE_HERO];

                $heroIds = ArrayHelper::getColumn($user->heroes, 'hero_id');
                $prizeHeroIds = array_values(array_map(function ($config) {
                    return $config['id'];
                }, $heroConfig));

                $diff = array_values(array_diff($prizeHeroIds, $heroIds));

                if (empty($diff)) {
                    $lootPrizes = [
                        BoxPrizes::ID_LOOT_EQUIPMENT_BREECHES_MINE_BOSS => 0,
                        BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_COPPER_INSERTS => 0,
                        BoxPrizes::ID_LOOT_EQUIPMENT_RESPIRATOR_DIGGER_HOMEMADE => 0,
                    ];

                    $prizeId = RandomHelper::randomKey($lootPrizes);
                    $prize = BoxPrizes::createById($user, $box, $prizeId);
                } else {
                    $rand = RandomHelper::randomKey($diff);
                    $heroId = $diff[$rand];
                    $entry = __::findEntry($heroConfig, fn($item) => $item['id'] === $heroId);

                    $prize = BoxPrizes::createById($user, $box, $entry[0]);
                }
            }
        } elseif ($prize instanceof AutoBotPrize) {
            $botType = $prize->getObject();
            $existBot = !$this->autoBotService->canAssign($user, $botType);

            if ($existBot) {
                $prize = BoxPrizes::createById($user, $box, BoxPrizes::ID_LOOT_EQUIPMENT_HELMET_COPPER_LOST_KNIGHT);
            }
        }

        return $prize;
    }

    private function generateMoneyPrize(UserAccount $user, BoxInterface $box): PrizeInterface
    {
        $prizes = $box::getConfigPrizes()[BoxPrizes::TYPE_MONEY];
        $prizeId = RandomHelper::randomKey($prizes);

        return BoxPrizes::createById($user, $box, $prizeId);
    }

    private function generateRandomPrize(BoxInterface $box, callable $prizeFilter = null): ?string
    {
        $probabilities = $box::getRarityProbabilities();

        $random = mt_rand() / mt_getrandmax();

        $cumulativeProbability = 0;

        foreach ($probabilities as $rarity => $probability) {
            $cumulativeProbability += $probability;

            if ($random <= $cumulativeProbability) {
                $prizeId = $this->getRandomRarityPrize($box, $rarity, $prizeFilter);

                if ($prizeId === null) {
                    continue;
                }

                return $prizeId;
            }
        }

        return null;
    }

    private function getRandomRarityPrize(BoxInterface $box, string $rarity, callable $prizeFilter = null): ?string
    {
        $rarityPrizes = $box::getRarityPrizes()[$rarity];
        $prizeCounts = $this->getUsedPrizeCounts($box);

        if ($prizeFilter) {
            $rarityPrizes = $prizeFilter($rarityPrizes);
        }

        shuffle($rarityPrizes);

        foreach ($rarityPrizes as $prizeId) {
            $maxCount = ArrayHelper::getValue($box::getPrizeCounts(), $prizeId);
            $usedCount = ArrayHelper::getValue($prizeCounts, $prizeId, 0);

            if ($maxCount !== null && $usedCount >= $maxCount) {
                continue;
            }

            return $prizeId;
        }

        return null;
    }

    private function getUsedPrizeCounts(BoxInterface $box): array
    {
        return $this->registerService->getRegisterCounts(PrizeRegister::SOURCE_BOX, $box->getType());
    }
}