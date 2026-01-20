<?php

namespace common\box\prizes;

use common\heroes\entities\HeroEntityAbstract;

class HeroPrize implements PrizeInterface
{
    protected string $id;
    protected HeroEntityAbstract $heroConfig;

    public function __construct(string $id, HeroEntityAbstract $heroConfig)
    {
        $this->id = $id;
        $this->heroConfig = $heroConfig;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return BoxPrizes::TYPE_HERO;
    }

    public function getTitle(): string
    {
        return $this->heroConfig->getName();
    }

    public function getObject(): HeroEntityAbstract
    {
        return $this->heroConfig;
    }

    public function getParams(): array
    {
        return [
            'type' => $this->getType(),
            'typeId' => $this->heroConfig->getID(),
            'typeCategory' => null,
            'title' => $this->heroConfig->getName(),
        ];
    }
}