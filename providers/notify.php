<?php
/**
 * Created by PhpStorm.
 * User: hossein142001
 * Date: 15.04.2017
 * Time: 20:13
 */

namespace hossein142001\notification\providers;
use hossein142001\notification\components\Provider;
use hossein142001\notification\components\Notification;
use Yii;

class notify  extends Provider
{
    /**
     * @param Notification $notification
     */
    public function send(Notification $notification)
    {
        if(empty($notification->notify)) return;

        Yii::$app->session->addFlash($notification->notify[0], $notification->notify[1]);

        $this->status = true;

    }
}