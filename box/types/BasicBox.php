<?php

namespace common\box\types;

use common\box\BoxTypes;
use common\box\BoxInterface;
use common\box\prizes\BoxPrizes;
use common\loot\Loots;
use common\models\billing\Currency;

class BasicBox extends Box implements BoxInterface
{
    public function getId(): string
    {
        return BoxTypes::TYPE_BASIC;
    }

    public function getType(): string
    {
        return BoxTypes::TYPE_BASIC;
    }

    public function getTitle(): string
    {
        return BoxTypes::getTitles()[$this->getType()];
    }

    public function getPrizes(): array
    {
        return $this->prizes;
    }

    public static function getDefaultPrizeId(): string
    {
        return BoxPrizes::ID_LOOT_MATERIAL_SHARD_QUARK;
    }

    public static function getConfigPrizes(): array
    {
        return [
            BoxPrizes::TYPE_LOOT => [
                // equipments
                BoxPrizes::ID_LOOT_EQUIPMENT_BOOTS_DIGGER_LEATHER => ['name' => Loots::NAME_EQUIPMENT_BOOTS_DIGGER_LEATHER, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_DIGGER_COMFORTABLE => ['name' => Loots::NAME_EQUIPMENT_GLOVES_DIGGER_COMFORTABLE, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_RESPIRATOR_DIGGER_HOMEMADE => ['name' => Loots::NAME_EQUIPMENT_RESPIRATOR_DIGGER_HOMEMADE, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_PICKAXE_LOST_MINER => ['name' => Loots::NAME_EQUIPMENT_PICKAXE_LOST_MINER, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_COAT_MINE_BOSS => ['name' => Loots::NAME_EQUIPMENT_COAT_MINE_BOSS, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_BREECHES_MINE_BOSS => ['name' => Loots::NAME_EQUIPMENT_BREECHES_MINE_BOSS, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_COPPER_INSERTS => ['name' => Loots::NAME_EQUIPMENT_GLOVES_COPPER_INSERTS, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_DRILL_LOST_HAND => ['name' => Loots::NAME_EQUIPMENT_DRILL_LOST_HAND, 'volume' => 1],

                // relics
                BoxPrizes::ID_LOOT_RELIC_SEAL_COAL => ['name' => Loots::NAME_RELIC_SEAL_COAL, 'volume' => 1],

                // materials
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_QUARK => ['name' => Loots::NAME_MATERIAL_SHARD_QUARK, 'volume' => [3, 5]],
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_FLUR => ['name' => Loots::NAME_MATERIAL_SHARD_FLUR, 'volume' => [3, 5]],
            ],
            BoxPrizes::TYPE_MONEY => [
                BoxPrizes::ID_MONEY_DUST_50 => ['percent' => 50, 'currency' => Currency::DUST],
                BoxPrizes::ID_MONEY_DUST_60 => ['percent' => 60, 'currency' => Currency::DUST],
                BoxPrizes::ID_MONEY_DUST_70 => ['percent' => 70, 'currency' => Currency::DUST],
                BoxPrizes::ID_MONEY_DUST_80 => ['percent' => 80, 'currency' => Currency::DUST],
                BoxPrizes::ID_MONEY_DUST_90 => ['percent' => 90, 'currency' => Currency::DUST],
                BoxPrizes::ID_MONEY_DUST_100 => ['percent' => 100, 'currency' => Currency::DUST],
            ],
        ];
    }

    public static function getRarityPrizes(): array
    {
        return [
            BoxPrizes::RARITY_5 => [ // Простые
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_QUARK,
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_FLUR,
            ],
            BoxPrizes::RARITY_4 => [ // Редкие
                BoxPrizes::ID_LOOT_EQUIPMENT_BOOTS_DIGGER_LEATHER,
                BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_DIGGER_COMFORTABLE,
                BoxPrizes::ID_LOOT_EQUIPMENT_RESPIRATOR_DIGGER_HOMEMADE,
            ],
            BoxPrizes::RARITY_3 => [ // Супер редкие
                BoxPrizes::ID_LOOT_EQUIPMENT_COAT_MINE_BOSS,
                BoxPrizes::ID_LOOT_EQUIPMENT_BREECHES_MINE_BOSS,
                BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_COPPER_INSERTS,
            ],
            BoxPrizes::RARITY_2 => [ // Невозможно редкие
                BoxPrizes::ID_LOOT_EQUIPMENT_PICKAXE_LOST_MINER,
                BoxPrizes::ID_LOOT_EQUIPMENT_DRILL_LOST_HAND,
            ],
            BoxPrizes::RARITY_1 => [ // Джекпот
                BoxPrizes::ID_LOOT_RELIC_SEAL_COAL,
            ]
        ];
    }

    public static function getRarityProbabilities(): array
    {
        return [
            BoxPrizes::RARITY_5 => 0.50,
            BoxPrizes::RARITY_4 => 0.30,
            BoxPrizes::RARITY_3 => 0.16,
            BoxPrizes::RARITY_2 => 0.035,
            BoxPrizes::RARITY_1 => 0.005,
        ];
    }

    public static function getPrizeCounts(): array
    {
        return [];
    }
}