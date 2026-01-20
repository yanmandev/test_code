<?php

namespace common\box\prizes;

use common\box\BoxInterface;

class BoxPrize implements PrizeInterface
{
    protected string $id;
    protected BoxInterface $box;
    protected int $count = 1;

    public function __construct(string $id, BoxInterface $box, int $count = 1)
    {
        $this->id = $id;
        $this->box = $box;
        $this->count = $count;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return BoxPrizes::TYPE_BOX;
    }

    public function getTitle(): string
    {
        return $this->box->getTitle();
    }

    public function getObject(): BoxInterface
    {
        return $this->box;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getParams(): array
    {
        return [
            'id' => $this->box->getId(),
            'type' => $this->box->getType(),
            'count' => $this->count,
        ];
    }
}