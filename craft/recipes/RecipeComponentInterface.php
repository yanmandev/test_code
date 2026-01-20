<?php

namespace common\craft\recipes;

interface RecipeComponentInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getTitle(): string;

    public function getObject(): mixed;

    public function getParams(): array;
}
