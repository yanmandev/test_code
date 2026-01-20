<?php

namespace common\craft\recipes;

use Money\Money;
use api\helpers\MoneyFormatHelper;

class MoneyComponent implements RecipeComponentInterface
{
    private Money $amount;

    public function __construct(Money $amount)
    {
        $this->amount = $amount;
    }

    public function getId(): string
    {
        $type = $this->getType();
        $currency = mb_strtolower($this->amount->getCurrency()->getCode());

        return "{$type}_{$currency}";
    }

    public function getType(): string
    {
        return RecipeComponents::TYPE_MONEY;
    }

    public function getTitle(): string
    {
        return RecipeComponents::getTypeTitles()[$this->getType()];
    }

    public function getObject(): Money
    {
        return $this->amount;
    }

    public function getParams(): array
    {
        return [
            'amount' => (float)MoneyFormatHelper::toNetAmount($this->amount),
            'currency' => $this->amount->getCurrency()
        ];
    }
}
