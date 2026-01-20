<?php

namespace common\craft\recipes;

use common\loot\LootInterface;

class LootComponent implements RecipeComponentInterface
{
    private LootInterface $loot;

    public function getId(): string
    {
        $type = $this->getType();
        $name = $this->loot->getName();

        return "{$type}_{$name}";
    }

    public function __construct(LootInterface $loot)
    {
        $this->loot = $loot;
    }

    public function getType(): string
    {
        return RecipeComponents::TYPE_LOOT;
    }

    public function getTitle(): string
    {
        return RecipeComponents::getTypeTitles()[$this->getType()];
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
            'name' => $this->loot->getName(),
            'title' => $this->loot->getTitle(),
            'volume' => $this->loot->getVolume()
        ];
    }
}
