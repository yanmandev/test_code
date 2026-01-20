<?php

namespace common\box\prizes;

use common\loot\LootInterface;
use common\loot\resources\Aqua;

class LootPrize implements PrizeInterface
{
    protected string $id;
    protected LootInterface $loot;

    public function __construct(string $id, LootInterface $loot)
    {
        $this->id = $id;
        $this->loot = $loot;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return BoxPrizes::TYPE_LOOT;
    }

    public function getTitle(): string
    {
        if ($this->loot instanceof Aqua) {
            return implode(' ', [
                $this->loot->getTitle(),
                "({$this->loot->getVolume()})",
            ]);
        }

        return $this->loot->getTitle();
    }

    public function getObject(): LootInterface
    {
        return $this->loot;
    }

    public function getParams(): array
    {
        return [
            'type' => $this->loot->getType(),
            'typeId' => $this->loot->getId(),
            'typeCategory' => $this->loot->getSubtype(),
            'title' => $this->loot->getTitle(),
            'volume' => $this->loot->getVolume()
        ];
    }
}