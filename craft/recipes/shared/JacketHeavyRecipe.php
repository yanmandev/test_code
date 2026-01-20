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

class JacketHeavyRecipe extends BaseRecipe implements RecipeInterface
{
    public function getId(): string
    {
        return Recipes::ID_JACKET_HEAVY;
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
        return Loots::obtain(Loots::NAME_EQUIPMENT_JACKET_HEAVY);
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
                'config' => ['name' => Loots::NAME_MATERIAL_SCRAP_CLOTH, 'volume' => 100]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_ROLL_CLOTH, 'volume' => 15]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_RIVET, 'volume' => 15]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_NUT, 'volume' => 15]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_COPPER_BRACKET, 'volume' => 15]
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
