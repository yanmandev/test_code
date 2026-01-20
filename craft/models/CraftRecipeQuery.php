<?php

namespace common\craft\models;

class CraftRecipeQuery extends \yii\db\ActiveQuery
{
    public function byRecipeId(string $id): self
    {
        return $this->andWhere(['recipe_id' => $id]);
    }

    public function byUser(int $id): self
    {
        return $this->andWhere(['user_id' => $id]);
    }

    public function byStatus(array $statuses): self
    {
        return $this->andWhere(['status' => $statuses]);
    }

    public function registered(): self
    {
        return $this->andWhere(['status' => CraftRecipe::STATUS_REGISTERED]);
    }

    public function exploring(): self
    {
        return $this->andWhere(['status' => CraftRecipe::STATUS_EXPLORING]);
    }

    public function explored(): self
    {
        return $this->andWhere(['status' => CraftRecipe::STATUS_EXPLORED]);
    }

    /**
     * {@inheritdoc}
     * @return CraftRecipe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CraftRecipe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
