<?php

namespace common\craft\helpers;

use common\models\user\UserAccount;
use common\craft\models\CraftRecipe;

class CraftHelper
{
    public static function prepareComponentVolume($volume, int $level): int|float|array
    {
        if ($level <= 0) {
            return $volume;
        }

        if (is_array($volume)) {
            return array_map(fn($item) => $item * $level, $volume);
        }

        return $volume * $level;
    }

    public static function isExistRecipe(UserAccount $user, string $id): bool
    {
        return CraftRecipe::find()->byUser($user->id)->byRecipeId($id)->exists();
    }
}