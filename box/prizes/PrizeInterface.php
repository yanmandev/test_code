<?php

namespace common\box\prizes;

interface PrizeInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getTitle(): string;

    public function getObject(): mixed;

    public function getParams(): array;
}