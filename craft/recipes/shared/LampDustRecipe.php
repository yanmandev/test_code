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

class LampDustRecipe extends BaseRecipe implements RecipeInterface
{
    public function getId(): string
    {
        return Recipes::ID_LAMP_DUST;
    }

    public function getTitle(): string
    {
        return Recipes::getTitles()[$this->getId()];
    }

    public function getRarity(): string
    {
        return Recipes::RARITY_RARE;
    }

    public function getObject(): LootInterface
    {
        return Loots::obtain(Loots::NAME_EQUIPMENT_LAMP_DUST);
    }

    public function getPrice(): Money
    {
        return $this->moneyHelper->parse(50_000_000, Currency::DUST);
    }

    public function getSchemeComponents(): array
    {
        return [
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_RESOURCE_IRON, 'volume' => 3_500]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_RESOURCE_COPPER, 'volume' => 2_500]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_CRYSTAL_REFLECTOR, 'volume' => 5]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_METAL_TUBE, 'volume' => 15]
            ],
            [
                'type' => RecipeComponents::TYPE_LOOT,
                'config' => ['name' => Loots::NAME_MATERIAL_COPPER_BRACKET, 'volume' => 50]
            ],
            [
                'type' => RecipeComponents::TYPE_MONEY,
                'config' => ['currency' => Currency::BASE_CURRENCY, 'amount' => 1.5]
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
                'volume' => [4, 6],
                'probability' => 100,
            ],
            [
                'name' => Loots::NAME_MATERIAL_SHARD_QUARK,
                'volume' => [4, 6],
                'probability' => 100,
            ],
        ];
    }
}
