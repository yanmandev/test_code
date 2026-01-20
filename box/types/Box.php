<?php

namespace common\box\types;

use common\box\prizes\PrizeInterface;

abstract class Box
{
    /** @var PrizeInterface[]  */
    protected array $prizes = [];

    public function setItems(array $prizes)
    {
        $this->prizes = $prizes;
    }

    public static function getRarityById(array $rarityPrizes, string $id): ?string
    {
        foreach ($rarityPrizes as $rarity => $ids) {
            if (in_array($id, $ids)) {
                return $rarity;
            }
        }

        return null;
    }

    public static function getTypeById(array $prizes, string $id): ?string
    {
        foreach ($prizes as $type => $ids) {
            if (isset($ids[$id])) {
                return $type;
            }
        }

        return null;
    }
}