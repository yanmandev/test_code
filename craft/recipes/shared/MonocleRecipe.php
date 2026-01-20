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

class MonocleRecipe extends BaseRecipe implements RecipeInterface
{
    public function getId(): string
    {
        return Recipes::ID_MONOCLE;
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
        return Loots::obtain(Loots::NAME_EQUIPMENT_MONOCLE);
    }

    public function getPrice(): Money
    {
        return $this->moneyHelper->parse(5_000_000, Currency::DUST);
    }

    public function getSchemeComponents(): array
    {
        return [
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_SAPPHIRE_GLASS, 'volume' => 40]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_NYLON_THREAD, 'volume' => 25]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_IRON_BRACKET, 'volume' => 15]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_COPPER_WIRE, 'volume' => 15]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_NUT, 'volume' => 10]
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
