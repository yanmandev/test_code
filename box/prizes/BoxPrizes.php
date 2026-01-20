<?php

namespace common\box\prizes;

use yii\helpers\ArrayHelper;
use common\helpers\MoneyHelper;
use common\models\user\UserAccount;
use common\clicker\helpers\ClickerHelper;
use common\heroes\Heroes;
use common\box\BoxInterface;
use common\box\BoxTypes;
use common\box\types\Box;
use common\loot\Loots;
use common\autobot\types\AutoBots;
use common\upgrades\Upgrades;

class BoxPrizes
{
    public const TYPE_HERO = 'hero';
    public const TYPE_LOOT = 'loot';
    public const TYPE_MONEY = 'money';
    public const TYPE_AUTO_BOT = 'auto_bot';
    public const TYPE_BOX = 'box';
    public const TYPE_UPGRADE = 'upgrade';

    public const RARITY_1 = 'rarity_1';
    public const RARITY_2 = 'rarity_2';
    public const RARITY_3 = 'rarity_3';
    public const RARITY_4 = 'rarity_4';
    public const RARITY_5 = 'rarity_5';
    public const RARITY_6 = 'rarity_6';
    public const RARITY_7 = 'rarity_7';
    public const RARITY_8 = 'rarity_8';
    public const RARITY_9 = 'rarity_9';

    // heroes
    public const ID_HERO_4 = 'hero_4';
    public const ID_HERO_5 = 'hero_5';
    public const ID_HERO_6 = 'hero_6';
    public const ID_HERO_7 = 'hero_7';
    public const ID_HERO_8 = 'hero_8';
    public const ID_HERO_9 = 'hero_9';
    public const ID_HERO_10 = 'hero_10';
    public const ID_HERO_11 = 'hero_11';
    public const ID_HERO_12 = 'hero_12';
    public const ID_HERO_13 = 'hero_13';

    // moneys
    public const ID_MONEY_DUST_5 = 'money_dust_5';
    public const ID_MONEY_DUST_10 = 'money_dust_10';
    public const ID_MONEY_DUST_15 = 'money_dust_15';
    public const ID_MONEY_DUST_20 = 'money_dust_20';
    public const ID_MONEY_DUST_25 = 'money_dust_25';
    public const ID_MONEY_DUST_30 = 'money_dust_30';
    public const ID_MONEY_DUST_40 = 'money_dust_40';
    public const ID_MONEY_DUST_50 = 'money_dust_50';
    public const ID_MONEY_DUST_60 = 'money_dust_60';
    public const ID_MONEY_DUST_70 = 'money_dust_70';
    public const ID_MONEY_DUST_80 = 'money_dust_80';
    public const ID_MONEY_DUST_90 = 'money_dust_90';
    public const ID_MONEY_DUST_100 = 'money_dust_100';
    public const ID_MONEY_DUST_BILLION = 'money_dust_billion';

    public const ID_MONEY_USDT_05 = 'money_usdt_05';
    public const ID_MONEY_USDT_5 = 'money_usdt_5';
    public const ID_MONEY_USDT_1 = 'money_usdt_1';
    public const ID_MONEY_USDT_2 = 'money_usdt_2';
    public const ID_MONEY_USDT_10 = 'money_usdt_10';
    public const ID_MONEY_USDT_25 = 'money_usdt_25';
    public const ID_MONEY_USDT_50 = 'money_usdt_50';
    public const ID_MONEY_USDT_100 = 'money_usdt_100';

    public const ID_MONEY_QRK = 'money_qrk';

    // autobots
    public const ID_AUTO_BOT_CD_1000 = 'auto_bot_cd_1000';

    // potions
    public const ID_LOOT_POTION_OIL_ENGINE = 'loot_oil_engine';
    public const ID_LOOT_POTION_AQUA_DISTILLED_DUST = 'loot_aqua_distilled_dust';
    public const ID_LOOT_POTION_OIL_QUARK = 'loot_oil_quark';

    // equipments
    public const ID_LOOT_EQUIPMENT_LAMP_DUST = 'loot_lamp_dust';
    public const ID_LOOT_EQUIPMENT_CLOAK_GOLDEN_LEATHER = 'loot_cloak_golden_leather';
    public const ID_LOOT_EQUIPMENT_HELMET_COPPER_LOST_KNIGHT = 'loot_helmet_copper_missing_knight';
    public const ID_LOOT_EQUIPMENT_POCKET_STEAM_GUN_1 = 'loot_pocket_steam_gun_one';
    public const ID_LOOT_EQUIPMENT_POCKET_STEAM_GUN_X = 'loot_pocket_steam_gun_x';
    public const ID_LOOT_EQUIPMENT_CASH_REGISTER_RITTY = 'loot_cash_register_ritty';
    public const ID_LOOT_EQUIPMENT_PICKAXE_LOST_MINER = 'loot_pickaxe_lost_miner';
    public const ID_LOOT_EQUIPMENT_BREECHES_MINE_BOSS = 'loot_breeches_mine_boss';
    public const ID_LOOT_EQUIPMENT_RESPIRATOR_DIGGER_HOMEMADE = 'loot_respirator_digger_homemade';
    public const ID_LOOT_EQUIPMENT_GLOVES_COPPER_INSERTS = 'loot_gloves_copper_inserts';
    public const ID_LOOT_EQUIPMENT_DRILL_LOST_HAND = 'loot_drill_lost_hand';
    public const ID_LOOT_EQUIPMENT_BOOTS_DIGGER_LEATHER = 'loot_boots_digger_leather';
    public const ID_LOOT_EQUIPMENT_GLOVES_DIGGER_COMFORTABLE = 'loot_gloves_digger_comfortable';
    public const ID_LOOT_EQUIPMENT_JUMPSUIT_DIGGER_PROF = 'loot_jumpsuit_digger_prof';
    public const ID_LOOT_EQUIPMENT_COAT_MINE_BOSS = 'loot_coat_mine_boss';
    public const ID_LOOT_EQUIPMENT_HAT_IRON_UNDERGROUND_MOD = 'loot_hat_iron_underground_mod';
    public const ID_LOOT_EQUIPMENT_GLOVES_LOVING_HEART = 'loot_gloves_loving_heart';
    public const ID_LOOT_EQUIPMENT_WIDOW_MAKER = 'loot_widow_maker';
    public const ID_LOOT_EQUIPMENT_STAFF_SOUL_QRK = 'loot_staff_soul_qrk';
    public const ID_LOOT_EQUIPMENT_DRUM_SPIRIT_ERT = 'loot_drum_spirit_ert';
    public const ID_LOOT_EQUIPMENT_SHOTGUN_STEAM_MEN = 'loot_shotgun_steam_men';
    public const ID_LOOT_EQUIPMENT_REVOLVER_COPPER_SAM = 'loot_revolver_cooper_sam';
    public const ID_LOOT_EQUIPMENT_RAPIER_RET = 'loot_rapier_ret';
    public const ID_LOOT_EQUIPMENT_MALLET_SP = 'loot_mallet_sp';
    public const ID_LOOT_EQUIPMENT_MALLET_CC = 'loot_mallet_cc';
    public const ID_LOOT_EQUIPMENT_QUARK_CUTTER = 'loot_quark_cutter';
    public const ID_LOOT_EQUIPMENT_GLADIUS_FLUR = 'loot_gladius_flur';
    public const ID_LOOT_EQUIPMENT_SHOTGUN_CUCUMBER = 'loot_shotgun_cucumber';
    public const ID_LOOT_EQUIPMENT_REVOLVER_JUSTICE_EARTH = 'loot_revolver_justice_ert';
    public const ID_LOOT_EQUIPMENT_GRENADE_PETARD = 'loot_grenade_petard';
    public const ID_LOOT_EQUIPMENT_GRENADE_GREEN = 'loot_grenade_green';
    public const ID_LOOT_EQUIPMENT_HELMET_QUARK = 'loot_helmet_quark';
    public const ID_LOOT_EQUIPMENT_COAT_PARADE = 'loot_coat_parade';
    public const ID_LOOT_EQUIPMENT_SHIELD_GUARDIAN_GARDENS = 'loot_shield_guardian_gardens';

    // materials
    public const ID_LOOT_MATERIAL_GEAR = 'loot_gear';
    public const ID_LOOT_MATERIAL_METAL_TUBE = 'loot_metal_tube';
    public const ID_LOOT_MATERIAL_BEARING = 'loot_bearing';
    public const ID_LOOT_MATERIAL_RUBBER_GASKET = 'loot_rubber_gasket';
    public const ID_LOOT_MATERIAL_SHARD_FLUR = 'loot_shard_flur';
    public const ID_LOOT_MATERIAL_SHARD_QUARK = 'loot_shard_quark';

    // relics
    public const ID_LOOT_RELIC_SEAL_COAL = 'loot_seal_coal';
    public const ID_LOOT_RELIC_SEAL_STEAM = 'loot_seal_steam';
    public const ID_LOOT_RELIC_SEAL_DUST = 'loot_seal_dust';
    public const ID_LOOT_RELIC_SEAL_QUARK = 'loot_seal_quark';
    public const ID_LOOT_RELIC_SEAL_FLUR = 'loot_seal_flur';
    public const ID_LOOT_RELIC_FRAGMENT_QUARK = 'loot_fragment_quark';
    public const ID_LOOT_RELIC_PACT_IRON = 'loot_pact_iron';
    public const ID_LOOT_RELIC_KIT_CLERK = 'loot_kit_clerk';
    public const ID_LOOT_RELIC_TABLET_RUSTED = 'loot_tablet_rusted';
    public const ID_LOOT_RELIC_LAMP_KEROSENE = 'loot_lamp_kerosene';
    public const ID_LOOT_RELIC_CANE_TIP_BARON_SAMEDI = 'loot_cane_tip_baron_samedi';
    public const ID_LOOT_RELIC_HEAD_JACK = 'loot_head_jack';

    // boxes
    public const ID_BOX_RARE = 'box_rare';

    // upgrades
    public const ID_UPGRADE_DRILL_HASHRATE = 'upgrade_drill_hashrate';
    public const ID_UPGRADE_DRILL_HASHRATE_HALLOWEEN = 'upgrade_drill_hashrate_halloween';
    public const ID_UPGRADE_INVENTORY_SIZE = 'upgrade_inventory_size';
    public const ID_UPGRADE_INVENTORY_SIZE_HALLOWEEN = 'upgrade_inventory_size_halloween';

    public static function createById(UserAccount $user, BoxInterface $box, string $id): PrizeInterface
    {
        $type = Box::getTypeById($box::getConfigPrizes(), $id);

        if ($type === null) {
            throw new \LogicException("Prize with ID {$id} not specified.");
        }

        $config = ArrayHelper::getValue($box::getConfigPrizes(), "{$type}.{$id}");

        if ($type === self::TYPE_HERO) {
            return self::createHeroPrize($user, $id, $config);
        } elseif ($type === self::TYPE_LOOT) {
            return self::createLootPrize($user, $id, $config);
        } elseif ($type === self::TYPE_AUTO_BOT) {
            return self::createAutoBotPrize($user, $id, $config);
        } elseif ($type === self::TYPE_MONEY) {
            return self::createMoneyPrize($user, $id, $config);
        } elseif ($type === self::TYPE_BOX) {
            return self::createBoxPrize($user, $id, $config);
        } elseif ($type === self::TYPE_UPGRADE) {
            return self::createUpgradePrize($user, $id, $config);
        }

        throw new \LogicException("It is impossible to create an object.");
    }

    private static function createHeroPrize(UserAccount $user, string $id, array $config): HeroPrize
    {
        $heroConfig = Heroes::obtain($config['id'], 1);

        return new HeroPrize($id, $heroConfig);
    }

    private static function createLootPrize(UserAccount $user, string $id, array $config): LootPrize
    {
        $loot = Loots::obtain($config['name']);
        $volume = $config['volume'];

        if (is_array($volume)) {
            $volume = rand($volume[0], $volume[1]);
        }

        $loot->setVolume($volume);

        return new LootPrize($id, $loot);
    }

    private static function createAutoBotPrize(UserAccount $user, string $id, array $config): AutoBotPrize
    {
        $type = ArrayHelper::getValue($config, 'type');

        $autoBot = AutoBots::obtain($user->clicker, $type);

        return new AutoBotPrize($id, $autoBot);
    }

    private static function createMoneyPrize(UserAccount $user, string $id, array $config): MoneyPrize
    {
        $percent = ArrayHelper::getValue($config, 'percent');
        $value = ArrayHelper::getValue($config, 'amount');
        $currency = ArrayHelper::getValue($config, 'currency');

        if (is_array($value)) {
            $value = rand($value[0], $value[1]);
        }

        $mh = MoneyHelper::getInstance();

        if ($percent !== null) {
            $incomePerDay = ClickerHelper::calculateMaxIncomePerDay($user->clicker, $user->currentHero);

            $amount = $incomePerDay->multiply($percent)->divide(100);
            $minAmount = $mh->parse($percent * 10, $incomePerDay->getCurrency()->getCode());

            if ($amount->lessThan($minAmount)) {
                $amount = $minAmount;
            }

            $amount = $mh->roundDown($amount, 2);
        } else {
            $amount = $mh->parse($value, $currency);
        }

        return new MoneyPrize($id, $amount, $percent);
    }

    private static function createBoxPrize(UserAccount $user, string $id, array $config): BoxPrize
    {
        $type = ArrayHelper::getValue($config, 'type');
        $count = ArrayHelper::getValue($config, 'count', 1);

        if (is_array($count)) {
            $count = rand($count[0], $count[1]);
        }

        $box = BoxTypes::create($type);

        return new BoxPrize($id, $box, $count);
    }

    private static function createUpgradePrize(UserAccount $user, string $id, array $config): UpgradePrize
    {
        $type = ArrayHelper::getValue($config, 'type');
        $count = ArrayHelper::getValue($config, 'count');
        $tag = ArrayHelper::getValue($config, 'tag');

        if (is_array($count)) {
            $count = rand($count[0], $count[1]);
        }

        $upgrade = Upgrades::obtain($type, $config);

        if ($tag) {
            $upgrade->setTag($tag);
        }

        return new UpgradePrize($id, $upgrade, $count);
    }
}