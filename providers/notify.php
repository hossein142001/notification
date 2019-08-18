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
use yii\helpers\ArrayHelper;

class notify  extends Provider
{
    /**
     * @param Notification $notification
     */
    public function send(Notification $notification)
    {
        if(empty($notification->notify)) return;

        $providerName = $notification->data['providerName'];
        $message_log = new Message();
        $message_log->from_id = $notification->fromId;
        $message_log->to_id = $toId;
        $message_log->event = $notification->name;
        $message_log->provider = $providerName;
        $message_log->status = 51;
        $message_log->title = $notification->subject;
        $message_log->message = $notification->content;
        $message_log->setParams(ArrayHelper::merge(['event' => $notification->name], $notification->params));
        $message_log->save();

        Yii::$app->session->addFlash($notification->notify[0], $notification->notify[1]);

        $this->status = true;

    }
}