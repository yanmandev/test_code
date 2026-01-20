<?php

namespace common\craft\recipes;

use common\loot\Loots;
use common\helpers\MoneyHelper;
use common\helpers\MoneyConverter;
use common\models\billing\Currency;

class RecipeComponents
{
    public const TYPE_LOOT = 'loot';
    public const TYPE_MONEY = 'money';

    public static function getTypeTitles(): array
    {
        return [
            self::TYPE_LOOT => 'Loot',
            self::TYPE_MONEY => 'Money'
        ];
    }

    public static function create(string $type, array $config): RecipeComponentInterface
    {
        if ($type === self::TYPE_LOOT) {
            $loot = Loots::obtain($config['name']);
            $loot->setVolume($config['volume']);

            return new LootComponent($loot);
        } elseif ($type === self::TYPE_MONEY) {
            $mh = MoneyHelper::getInstance();
            $mc = MoneyConverter::getInstance();

            $amount = $mh->parse($config['amount'], $config['currency']);

            if ($amount->getCurrency()->getCode() <> Currency::QRK) {
                $amount = $mc->convert($amount, Currency::QRK);
                $amount = $mh->roundUp($amount, 2);
            }

            return new MoneyComponent($amount);
        }

        throw new \LogicException("Invalid create object.");
    }
}
