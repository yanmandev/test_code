<?php

namespace common\box\prizes;

use Money\Money;
use common\billing\helpers\ConvertCurrencyHelper;
use api\helpers\MoneyFormatHelper;

class MoneyPrize implements PrizeInterface
{
    protected string $id;
    protected Money $amount;
    protected int|float|null $percent = null;

    public function __construct(string $id, $amount, int|float $percent = null)
    {
        $this->id = $id;
        $this->amount = $amount;
        $this->percent = $percent;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return BoxPrizes::TYPE_MONEY;
    }

    public function getTitle(): string
    {
        $percent = $this->getPercent();

        if ($percent) {
            return "{$percent}% DUST of daily income";
        }

        $amount = MoneyFormatHelper::toNetAmount($this->amount);
        $currency = ConvertCurrencyHelper::simplifyCurrency($this->amount->getCurrency()->getCode());

        return "{$amount} {$currency}";
    }

    public function getObject(): Money
    {
        return $this->amount;
    }

    public function getParams(): array
    {
        $percent = $this->getPercent();
        $currency = $this->amount->getCurrency()->getCode();

        return [
            'type' => $this->getType(),
            'typeId' => null,
            'typeCategory' => null,
            'title' => null,
            'percent' => $percent,
            'amount' => [
                'amount' => MoneyFormatHelper::toNetAmount($this->amount),
                'currency' => ConvertCurrencyHelper::simplifyCurrency($currency)
            ]
        ];
    }

    private function getPercent(): int|float|null
    {
        return $this->percent;
    }
}