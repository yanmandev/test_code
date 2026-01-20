<?php

namespace common\craft\recipes;

use Yii;
use common\craft\recipes\shared\BoltRecipe;
use common\craft\recipes\shared\MetalPlateRecipe;
use common\craft\recipes\shared\CrystalReflectorRecipe;
use common\craft\recipes\shared\CashRegisterRittyRecipe;
use common\craft\recipes\shared\LampDustRecipe;
use common\craft\recipes\shared\JumpsuitDiggerProfRecipe;
use common\craft\recipes\shared\RapierRetributionRecipe;
use common\craft\recipes\shared\ShotgunSteamMentonRecipe;
use common\craft\recipes\shared\StaffSoulQuarkRecipe;
use common\craft\recipes\shared\GladiusFlurRecipe;
use common\craft\recipes\shared\QuarkCutterRecipe;
use common\craft\recipes\shared\JacketHeavyRecipe;
use common\craft\recipes\shared\MonocleRecipe;
use common\craft\recipes\shared\SpyglassRecipe;
use common\craft\recipes\shared\WristwatchRecipe;
use common\craft\recipes\shared\HealingBigRecipe;
use common\craft\recipes\shared\HealingSmallRecipe;
use common\craft\recipes\shared\SerumPurityRecipe;
use common\craft\recipes\shared\LanternSteamRecipe;
use common\craft\recipes\shared\CopperWireRecipe;
use common\craft\recipes\shared\GearRecipe;
use common\craft\recipes\shared\MetalTubeRecipe;
use common\craft\recipes\shared\RivetRecipe;

class Recipes
{
    public const ID_BOLT = 'bolt';
    public const ID_METAL_PLATE = 'metal_plate';
    public const ID_CRYSTAL_REFLECTOR = 'crystal_reflector';
    public const ID_CASH_REGISTER_RITTY = 'cash_register_ritty';
    public const ID_LAMP_DUST = 'lamp_dust';
    public const ID_JUMPSUIT_DIGGER_PROF = 'jumpsuit_digger_prof';
    public const ID_RAPIER_RET = 'rapier_ret';
    public const ID_SHOTGUN_STEAM_MEN = 'shotgun_steam_men';
    public const ID_STAFF_SOUL_QRK = 'staff_soul_qrk';
    public const ID_QUARK_CUTTER = 'quark_cutter';
    public const ID_GLADIUS_FLUR = 'gladius_flur';
    public const ID_WRISTWATCH = 'wristwatch';
    public const ID_SPYGLASS = 'spyglass';
    public const ID_JACKET_HEAVY = 'jacket_heavy';
    public const ID_MONOCLE = 'monocle';
    public const ID_LANTERN_STEAM = 'lantern_steam';
    public const ID_HEALING_SMALL = 'healing_small';
    public const ID_HEALING_BIG = 'healing_big';
    public const ID_SERUM_PURITY = 'serum_purity';
    public const ID_METAL_TUBE = 'metal_tube';
    public const ID_GEAR = 'gear';
    public const ID_RIVET = 'rivet';
    public const ID_COPPER_WIRE = 'copper_wire';

    public const RARITY_SIMPLE = 'simple';
    public const RARITY_UNUSUAL = 'unusual';
    public const RARITY_RARE = 'rare';
    public const RARITY_EPIC = 'epic';
    public const RARITY_LEGENDARY = 'legendary';

    public static function getIDs(): array
    {
        return [
            self::ID_BOLT,
            self::ID_METAL_PLATE,
            self::ID_CRYSTAL_REFLECTOR,
            self::ID_CASH_REGISTER_RITTY,
            self::ID_LAMP_DUST,
            self::ID_JUMPSUIT_DIGGER_PROF,
            self::ID_RAPIER_RET,
            self::ID_SHOTGUN_STEAM_MEN,
            self::ID_STAFF_SOUL_QRK,
            self::ID_QUARK_CUTTER,
            self::ID_GLADIUS_FLUR,
            self::ID_WRISTWATCH,
            self::ID_SPYGLASS,
            self::ID_JACKET_HEAVY,
            self::ID_MONOCLE,
            self::ID_LANTERN_STEAM,
            self::ID_HEALING_SMALL,
            self::ID_HEALING_BIG,
            self::ID_SERUM_PURITY,
            self::ID_METAL_TUBE,
            self::ID_GEAR,
            self::ID_RIVET,
            self::ID_COPPER_WIRE,
        ];
    }

    public static function getDefaultIds(): array
    {
        return [
            self::ID_BOLT,
            self::ID_METAL_PLATE,
            self::ID_CRYSTAL_REFLECTOR,
        ];
    }

    public static function createComponents(array $scheme): array
    {
        $components = [];

        foreach ($scheme as $item) {
            $components[] = RecipeComponents::create($item['type'], $item['config']);
        }

        return $components;
    }

    public static function getTitles(): array
    {
        return [
            self::ID_BOLT => 'Bolt',
            self::ID_METAL_PLATE => 'Metal plate',
            self::ID_CRYSTAL_REFLECTOR => 'Crystal Reflector',
            self::ID_CASH_REGISTER_RITTY => 'Cash Register Ritty',
            self::ID_LAMP_DUST => 'Lamp with Dust',
            self::ID_JUMPSUIT_DIGGER_PROF => 'Jumpsuit of a professional digger',
            self::ID_RAPIER_RET => 'Rapier of Retribution',
            self::ID_SHOTGUN_STEAM_MEN => 'Shotgun Steam Menton',
            self::ID_STAFF_SOUL_QRK => 'Quark Soul Staff',
            self::ID_QUARK_CUTTER => 'Quark cutter',
            self::ID_GLADIUS_FLUR => 'Flur Gladius',
            self::ID_WRISTWATCH => 'Wristwatch',
            self::ID_SPYGLASS => 'Spyglass',
            self::ID_JACKET_HEAVY => 'Heavy jacket',
            self::ID_MONOCLE => 'Monocle',
            self::ID_LANTERN_STEAM => 'Steam lantern',
            self::ID_HEALING_SMALL => 'Small Healing Potion',
            self::ID_HEALING_BIG => 'Big Healing Potion',
            self::ID_SERUM_PURITY => 'Purity Serum',
            self::ID_METAL_TUBE => 'Metal tube',
            self::ID_GEAR => 'Gear',
            self::ID_RIVET => 'Rivet',
            self::ID_COPPER_WIRE => 'Copper wire',
        ];
    }

    public static function create(string $id): RecipeInterface
    {
        $class = match ($id) {
            self::ID_BOLT => BoltRecipe::class,
            self::ID_METAL_PLATE => MetalPlateRecipe::class,
            self::ID_CRYSTAL_REFLECTOR => CrystalReflectorRecipe::class,
            self::ID_CASH_REGISTER_RITTY => CashRegisterRittyRecipe::class,
            self::ID_LAMP_DUST => LampDustRecipe::class,
            self::ID_JUMPSUIT_DIGGER_PROF => JumpsuitDiggerProfRecipe::class,
            self::ID_RAPIER_RET => RapierRetributionRecipe::class,
            self::ID_SHOTGUN_STEAM_MEN => ShotgunSteamMentonRecipe::class,
            self::ID_STAFF_SOUL_QRK => StaffSoulQuarkRecipe::class,
            self::ID_QUARK_CUTTER => QuarkCutterRecipe::class,
            self::ID_GLADIUS_FLUR => GladiusFlurRecipe::class,
            self::ID_WRISTWATCH => WristwatchRecipe::class,
            self::ID_SPYGLASS => SpyglassRecipe::class,
            self::ID_JACKET_HEAVY => JacketHeavyRecipe::class,
            self::ID_MONOCLE => MonocleRecipe::class,
            self::ID_LANTERN_STEAM => LanternSteamRecipe::class,
            self::ID_HEALING_SMALL => HealingSmallRecipe::class,
            self::ID_HEALING_BIG => HealingBigRecipe::class,
            self::ID_SERUM_PURITY => SerumPurityRecipe::class,
            self::ID_METAL_TUBE => MetalTubeRecipe::class,
            self::ID_GEAR => GearRecipe::class,
            self::ID_RIVET => RivetRecipe::class,
            self::ID_COPPER_WIRE => CopperWireRecipe::class,
            default => throw new \LogicException("Invalid recipe ID {$id}.")
        };

        return Yii::createObject($class);
    }
}
