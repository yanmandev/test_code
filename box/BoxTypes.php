<?php

namespace common\box;

use common\box\types\BasicBox;
use common\box\types\MegaBox;
use common\box\types\RareBox;

class BoxTypes
{
    public const TYPE_BASIC = 'basic';
    public const TYPE_RARE = 'rare';
    public const TYPE_MEGA = 'mega';

    public static function create(string $type): BoxInterface
    {
        $class = match ($type) {
            BoxTypes::TYPE_BASIC => BasicBox::class,
            BoxTypes::TYPE_RARE => RareBox::class,
            BoxTypes::TYPE_MEGA => MegaBox::class,
        };

        return new $class();
    }

    public static function getTitles(): array
    {
        return [
            self::TYPE_BASIC => 'Basic box',
            self::TYPE_RARE => 'Rare box',
            self::TYPE_MEGA => 'Mega box',
        ];
    }
}