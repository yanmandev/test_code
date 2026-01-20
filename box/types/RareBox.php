<?php

namespace common\box\types;

use common\box\BoxTypes;
use common\box\BoxInterface;
use common\box\prizes\BoxPrizes;
use common\loot\Loots;
use common\models\billing\Currency;

class RareBox extends Box implements BoxInterface
{
    public function getId(): string
    {
        return BoxTypes::TYPE_RARE;
    }

    public function getType(): string
    {
        return BoxTypes::TYPE_RARE;
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
        return BoxPrizes::ID_MONEY_DUST_30;
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
                BoxPrizes::ID_LOOT_RELIC_SEAL_STEAM => ['name' => Loots::NAME_RELIC_SEAL_STEAM, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_SEAL_DUST => ['name' => Loots::NAME_RELIC_SEAL_DUST, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_SEAL_QUARK => ['name' => Loots::NAME_RELIC_SEAL_QUARK, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_SEAL_FLUR => ['name' => Loots::NAME_RELIC_SEAL_FLUR, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_LAMP_KEROSENE => ['name' => Loots::NAME_RELIC_LAMP_KEROSENE, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_PACT_IRON => ['name' => Loots::NAME_RELIC_PACT_IRON, 'volume' => 1],
            ],
            BoxPrizes::TYPE_MONEY => [
                BoxPrizes::ID_MONEY_DUST_30 => ['percent' => 30, 'currency' => Currency::DUST],
                BoxPrizes::ID_MONEY_DUST_40 => ['percent' => 40, 'currency' => Currency::DUST],
            ],
        ];
    }

    public static function getRarityPrizes(): array
    {
        return [
            BoxPrizes::RARITY_5 => [ // Простые
                BoxPrizes::ID_LOOT_EQUIPMENT_BOOTS_DIGGER_LEATHER,
                BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_DIGGER_COMFORTABLE,
                BoxPrizes::ID_LOOT_EQUIPMENT_RESPIRATOR_DIGGER_HOMEMADE,

                BoxPrizes::ID_MONEY_DUST_30,
            ],
            BoxPrizes::RARITY_4 => [ // Редкие
                BoxPrizes::ID_LOOT_EQUIPMENT_GLOVES_COPPER_INSERTS,
                BoxPrizes::ID_LOOT_EQUIPMENT_BREECHES_MINE_BOSS,
                BoxPrizes::ID_LOOT_EQUIPMENT_COAT_MINE_BOSS,

                BoxPrizes::ID_LOOT_RELIC_SEAL_COAL,

                BoxPrizes::ID_MONEY_DUST_40,
            ],
            BoxPrizes::RARITY_3 => [ // Супер редкие
                BoxPrizes::ID_LOOT_EQUIPMENT_PICKAXE_LOST_MINER,
                BoxPrizes::ID_LOOT_EQUIPMENT_DRILL_LOST_HAND,

                BoxPrizes::ID_LOOT_EQUIPMENT_PICKAXE_LOST_MINER,
                BoxPrizes::ID_LOOT_EQUIPMENT_DRILL_LOST_HAND,

                BoxPrizes::ID_LOOT_RELIC_SEAL_STEAM,
                BoxPrizes::ID_LOOT_RELIC_LAMP_KEROSENE,
            ],
            BoxPrizes::RARITY_2 => [ // Невозможно редкие
                BoxPrizes::ID_LOOT_RELIC_SEAL_DUST,
                BoxPrizes::ID_LOOT_RELIC_SEAL_QUARK,
                BoxPrizes::ID_LOOT_RELIC_PACT_IRON,
            ],
            BoxPrizes::RARITY_1 => [ // Джекпот
                BoxPrizes::ID_LOOT_RELIC_SEAL_FLUR,
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