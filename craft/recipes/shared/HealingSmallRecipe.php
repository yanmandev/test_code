<?php

namespace common\craft\recipes\shared;

use Money\Money;
use common\models\billing\Currency;
use common\loot\Loots;
use common\loot\LootInterface;
use common\craft\recipes\Recipes;
use common\craft\recipes\BaseRecipe;
use common\craft\recipes\RecipeInterface;
use common\craft\recipes\RecipeComponents;

class HealingSmallRecipe extends BaseRecipe implements RecipeInterface
{
    public function getId(): string
    {
        return Recipes::ID_HEALING_SMALL;
    }

    public function getTitle(): string
    {
        return Recipes::getTitles()[$this->getId()];
    }

    public function getRarity(): string
    {
        return Recipes::RARITY_UNUSUAL;
    }

    public function getObject(): LootInterface
    {
        $loot = Loots::obtain(Loots::NAME_POTION_HEALING_SMALL);
        $loot->setVolume(10);

        return $loot;
    }

    public function getPrice(): Money
    {
        return $this->moneyHelper->parse(100_000_000, Currency::DUST);
    }

    public function getSchemeComponents(): array
    {
        return [
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_COPPER_CASE, 'volume' => 5]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_SHARD_FLUR, 'volume' => 3]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_POTION_AQUA_DISTILLED_DUST, 'volume' => 5]
            ],
            [
                'type' => RecipeComponents::TYPE_MONEY,
                'config' => ['currency' => Currency::BASE_CURRENCY, 'amount' => 0.5]
            ],
        ];
    }

    public function getComponents(): array
    {
        return Recipes::createComponents($this->getSchemeComponents());
    }

    public function getBreakdownComponents(): array
    {
        return [
            [
                'name' => Loots::NAME_MATERIAL_SHARD_FLUR,
                'volume' => [2, 4],
                'probability' => 100,
            ],
            [
                'name' => Loots::NAME_MATERIAL_SHARD_QUARK,
                'volume' => [2, 4],
                'probability' => 100,
            ],
        ];
    }
}
