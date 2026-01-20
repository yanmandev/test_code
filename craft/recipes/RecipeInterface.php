<?php

namespace common\craft\recipes;

use Money\Money;

interface RecipeInterface
{
    public function getId(): string;

    public function getTitle(): string;

    public function getRarity(): string;

    public function getObject(): mixed;

    public function getPrice(): Money;

    public function getSchemeComponents(): array;

    /**
     * @return RecipeComponentInterface[]
     */
    public function getComponents(): array;

    public function getBreakdownComponents(): array;
}
