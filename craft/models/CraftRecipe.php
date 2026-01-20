<?php

namespace common\craft\models;

use Carbon\Carbon;
use yii\db\ActiveQuery;
use yarcode\base\ActiveRecord;
use ss\core\behaviors\TimestampBehavior;
use common\models\user\UserAccount;
use common\models\user\UserAccountQuery;

/**
 * @property int $id
 * @property int $user_id
 * @property string $recipe_id
 * @property int $status
 * @property string $explore_started_at
 * @property string $explore_finished_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserAccount $user
 */
class CraftRecipe extends ActiveRecord
{
    public const STATUS_REGISTERED = 0;
    public const STATUS_EXPLORING = 1;
    public const STATUS_EXPLORED = 2;

    public static function getStatusNames(): array
    {
        return [
            self::STATUS_REGISTERED => 'registered',
            self::STATUS_EXPLORING => 'exploring',
            self::STATUS_EXPLORED => 'explored',
        ];
    }

    public function isExploringExpired(): bool
    {
        if (!$this->explore_started_at || !$this->explore_finished_at) {
            return false;
        }

        $now = Carbon::now('utc');
        $finishedAt = Carbon::parse($this->explore_finished_at, $now->getTimezone());

        return $now->greaterThanOrEqualTo($finishedAt);
    }

    public function isStatusRegistered(): bool
    {
        return $this->status === self::STATUS_REGISTERED;
    }

    public function isStatusExploring(): bool
    {
        return $this->status === self::STATUS_EXPLORING;
    }

    public function isStatusExplored(): bool
    {
        return $this->status === self::STATUS_EXPLORED;
    }

    public function getUser(): ActiveQuery|UserAccountQuery
    {
        return $this->hasOne(UserAccount::class, ['id' => 'user_id']);
    }

    public static function find(): CraftRecipeQuery
    {
        return new CraftRecipeQuery(get_called_class());
    }

    public function behaviors(): array
    {
        return [
            'ts' => TimestampBehavior::class,
        ];
    }

    public static function tableName(): string
    {
        return '{{%craft_recipe}}';
    }
}
