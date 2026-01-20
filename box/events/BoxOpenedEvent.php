<?php

namespace common\box\events;

use yii\base\Event;
use common\box\BoxInterface;
use common\box\prizes\PrizeInterface;
use common\models\user\UserAccount;

class BoxOpenedEvent extends Event
{
    const EVENT_OPENED = 'onBoxOpened';

    public UserAccount $user;
    public BoxInterface $box;
    /** @var PrizeInterface[] */
    public array $prizes;

    public static function obtain(UserAccount $user, BoxInterface $box, array $prizes): self
    {
        return new static([
            'user' => $user,
            'box' => $box,
            'prizes' => $prizes,
        ]);
    }
}