<?php

namespace common\box\types;

use common\box\BoxTypes;
use common\box\BoxInterface;
use common\box\prizes\BoxPrizes;
use common\loot\Loots;
use common\models\billing\Currency;
use common\upgrades\Upgrades;

class MegaBox extends Box implements BoxInterface
{
    public function getId(): string
    {
        return BoxTypes::TYPE_MEGA;
    }

    public function getType(): string
    {
        return BoxTypes::TYPE_MEGA;
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
                // potions
                BoxPrizes::ID_LOOT_POTION_OIL_QUARK => ['name' => Loots::NAME_POTION_OIL_QUARK, 'volume' => [2, 3]],

                // materials
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_QUARK => ['name' => Loots::NAME_MATERIAL_SHARD_QUARK, 'volume' => [20, 40]],
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_FLUR => ['name' => Loots::NAME_MATERIAL_SHARD_FLUR, 'volume' => [20, 40]],

                // equipments
                BoxPrizes::ID_LOOT_EQUIPMENT_HELMET_QUARK => ['name' => Loots::NAME_EQUIPMENT_HELMET_QUARK, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_COAT_PARADE => ['name' => Loots::NAME_EQUIPMENT_COAT_PARADE, 'volume' => 1],
                BoxPrizes::ID_LOOT_EQUIPMENT_SHIELD_GUARDIAN_GARDENS => ['name' => Loots::NAME_EQUIPMENT_SHIELD_GUARDIAN_GARDENS, 'volume' => 1],

                // relics
                BoxPrizes::ID_LOOT_RELIC_SEAL_QUARK => ['name' => Loots::NAME_RELIC_SEAL_QUARK, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_SEAL_FLUR => ['name' => Loots::NAME_RELIC_SEAL_FLUR, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_FRAGMENT_QUARK => ['name' => Loots::NAME_RELIC_FRAGMENT_QUARK, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_PACT_IRON => ['name' => Loots::NAME_RELIC_PACT_IRON, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_KIT_CLERK => ['name' => Loots::NAME_RELIC_KIT_CLERK, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_TABLET_RUSTED => ['name' => Loots::NAME_RELIC_TABLET_RUSTED, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_LAMP_KEROSENE => ['name' => Loots::NAME_RELIC_LAMP_KEROSENE, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_CANE_TIP_BARON_SAMEDI => ['name' => Loots::NAME_RELIC_CANE_TIP_BARON_SAMEDI, 'volume' => 1],
                BoxPrizes::ID_LOOT_RELIC_HEAD_JACK => ['name' => Loots::NAME_RELIC_HEAD_JACK, 'volume' => 1],
            ],
            BoxPrizes::TYPE_MONEY => [
                BoxPrizes::ID_MONEY_QRK => ['amount' => [100, 500], 'currency' => Currency::QRK],
            ],
            BoxPrizes::TYPE_BOX => [
                BoxPrizes::ID_BOX_RARE => ['type' => BoxTypes::TYPE_RARE, 'count' => 1],
            ],
            BoxPrizes::TYPE_UPGRADE => [
                BoxPrizes::ID_UPGRADE_DRILL_HASHRATE => ['type' => Upgrades::TYPE_DRILL_HASHRATE, 'hours' => 72, 'count' => [3, 6]],
                // halloween upgrades
                BoxPrizes::ID_UPGRADE_DRILL_HASHRATE_HALLOWEEN => ['type' => Upgrades::TYPE_DRILL_HASHRATE, 'hours' => 2_160, 'tag' => Upgrades::TAG_HALLOWEEN, 'count' => 1],
                BoxPrizes::ID_UPGRADE_INVENTORY_SIZE_HALLOWEEN => ['type' => Upgrades::TYPE_INVENTORY_SIZE, 'cells' => 10, 'tag' => Upgrades::TAG_HALLOWEEN, 'count' => 1],
            ]
        ];
    }

    public static function getRarityPrizes(): array
    {
        return [
            BoxPrizes::RARITY_5 => [ // Простые
                BoxPrizes::ID_LOOT_EQUIPMENT_HELMET_QUARK,
                BoxPrizes::ID_LOOT_EQUIPMENT_COAT_PARADE,

                BoxPrizes::ID_LOOT_RELIC_LAMP_KEROSENE,

                BoxPrizes::ID_UPGRADE_DRILL_HASHRATE,
            ],
            BoxPrizes::RARITY_4 => [ // Редкие
                BoxPrizes::ID_LOOT_RELIC_TABLET_RUSTED,

                BoxPrizes::ID_LOOT_RELIC_SEAL_QUARK,
                BoxPrizes::ID_LOOT_RELIC_KIT_CLERK,
            ],
            BoxPrizes::RARITY_3 => [ // Супер редкие
                //BoxPrizes::ID_LOOT_EQUIPMENT_SHIELD_GUARDIAN_GARDENS,

                BoxPrizes::ID_LOOT_POTION_OIL_QUARK,

                BoxPrizes::ID_LOOT_RELIC_FRAGMENT_QUARK,
                BoxPrizes::ID_LOOT_RELIC_PACT_IRON,
                //BoxPrizes::ID_LOOT_RELIC_HEAD_JACK,

                //BoxPrizes::ID_UPGRADE_DRILL_HASHRATE_HALLOWEEN,
                //BoxPrizes::ID_UPGRADE_INVENTORY_SIZE_HALLOWEEN,
            ],
            BoxPrizes::RARITY_2 => [ // Невозможно редкие
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_QUARK,
                BoxPrizes::ID_LOOT_MATERIAL_SHARD_FLUR,

                BoxPrizes::ID_LOOT_RELIC_SEAL_FLUR,
            ],
            BoxPrizes::RARITY_1 => [ // Джекпот
                BoxPrizes::ID_LOOT_RELIC_CANE_TIP_BARON_SAMEDI,

                BoxPrizes::ID_BOX_RARE,
            ]
        ];
    }

    public static function getFilterPrizes(): array
    {
        return [
            // equipments
            BoxPrizes::ID_LOOT_EQUIPMENT_HELMET_QUARK,
            BoxPrizes::ID_LOOT_EQUIPMENT_COAT_PARADE,

            // relics
            BoxPrizes::ID_LOOT_RELIC_SEAL_QUARK,
            BoxPrizes::ID_LOOT_RELIC_SEAL_FLUR,
            BoxPrizes::ID_LOOT_RELIC_FRAGMENT_QUARK,
            BoxPrizes::ID_LOOT_RELIC_PACT_IRON,
            BoxPrizes::ID_LOOT_RELIC_KIT_CLERK,
            BoxPrizes::ID_LOOT_RELIC_CANE_TIP_BARON_SAMEDI,
            //BoxPrizes::ID_LOOT_RELIC_HEAD_JACK,

            // upgrades
            //BoxPrizes::ID_UPGRADE_INVENTORY_SIZE_HALLOWEEN,
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
        return [
            BoxPrizes::ID_LOOT_RELIC_CANE_TIP_BARON_SAMEDI => 5,
        ];
    }
}