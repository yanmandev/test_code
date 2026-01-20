<?php

namespace common\box\prizes;

use common\upgrades\UpgradeInterface;

class UpgradePrize implements PrizeInterface
{
    protected string $id;
    protected UpgradeInterface $upgrade;
    protected int $count = 1;

    public function __construct(string $id, UpgradeInterface $upgrade, int $count = 1)
    {
        $this->id = $id;
        $this->upgrade = $upgrade;
        $this->count = $count;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return BoxPrizes::TYPE_UPGRADE;
    }

    public function getTitle(): string
    {
        return $this->upgrade->getTitle();
    }

    public function getObject(): UpgradeInterface
    {
        return $this->upgrade;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getParams(): array
    {
        return array_merge([
            'id' => $this->upgrade->getId(),
            'type' => $this->upgrade->getType(),
            'tag' => $this->upgrade->getTag(),
            'count' => $this->count,
        ], $this->upgrade->getParams());
    }
}