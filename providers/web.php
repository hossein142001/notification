<?php
/**
 * Created by PhpStorm.
 * User: hossein142001
 * Date: 15.04.2017
 * Time: 20:13
 */

namespace hossein142001\notification\providers;

use hiiran\api\v1\modules\domain\models\Domain;
use hossein142001\notification\components\Notification;
use hossein142001\notification\components\Provider;
use hossein142001\notification\models\Message;
use yii\helpers\ArrayHelper;

class web extends Provider
{
    /**
     * @param Notification $notification
     * @return bool
     */
    public function send(Notification $notification)
    {
        if (empty($notification->toId)) return;

        if (is_array($notification->toId)) {
            $toIds = $notification->toId;
        } else {
            $toIds = [$notification->toId];
        }

        \Yii::$app->db->open();
        foreach ($toIds as $toId) {
            try {
                $providerName = $notification->data['providerName'];
                $message = new Message();
                $message->from_id = $notification->fromId;
                $message->to_id = $toId;
                $message->event = $notification->name;
                $message->provider = $providerName;
                $message->status = 51;
                $message->title = $notification->subject;
                $message->message = $notification->content;
                $message->setParams(ArrayHelper::merge(['event' => $notification->name], $notification->params));
                $status = $message->save();
                unset($message);
            } catch (\Exception $e) {
                $this->errors[] = $e->getMessage();
            }

            $this->status[$toId] = $status;
        }
        \Yii::$app->db->close();

    }
}