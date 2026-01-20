<?php

namespace common\box;

interface BoxInterface
{
    public function getId(): string;

    public function getType(): string;

    public function getTitle(): string;

    public function getPrizes(): array;

    public static function getDefaultPrizeId(): string;

    public static function getConfigPrizes(): array;

    public static function getRarityPrizes(): array;

    public static function getRarityProbabilities(): array;

    public static function getPrizeCounts(): array;
}