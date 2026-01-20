<?php

namespace common\craft\recipes;

use common\helpers\MoneyHelper;
use common\helpers\MoneyConverter;

class BaseRecipe
{
   protected MoneyHelper $moneyHelper;
   protected MoneyConverter $moneyConverter;

   public function __construct(MoneyHelper $moneyHelper, MoneyConverter $moneyConverter)
   {
       $this->moneyHelper = $moneyHelper;
       $this->moneyConverter = $moneyConverter;
   }
}
