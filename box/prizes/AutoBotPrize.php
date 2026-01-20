<?php

namespace common\box\prizes;

use common\autobot\types\AutoBotInterface;

class AutoBotPrize implements PrizeInterface
{
    protected string $id;
    protected AutoBotInterface $autoBot;

    public function __construct(string $id, AutoBotInterface $autoBot)
    {
        $this->id = $id;
        $this->autoBot = $autoBot;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return BoxPrizes::TYPE_AUTO_BOT;
    }

    public function getTitle(): string
    {
        return $this->autoBot->getTitle();
    }

    public function getObject(): AutoBotInterface
    {
        return $this->autoBot;
    }

    public function getParams(): array
    {
        return [
            'type' => $this->autoBot->getType(),
            'typeId' => $this->autoBot->getType(),
            'typeCategory' => null,
            'title' => $this->autoBot->getTitle(),
        ];
    }
}