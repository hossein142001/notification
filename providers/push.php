<?php
/**
 * Created by PhpStorm.
 * User: hossein142001
 * Date: 15.04.2017
 * Time: 20:13
 */

namespace hossein142001\notification\providers;

use hossein142001\notification\components\Notification;
use hossein142001\notification\components\Provider;
use Yii;

class push  extends Provider
{
    /**
     * @param Notification $notification
     */
    public function send(Notification $notification)
    {
        if(empty($notification->token)) return;

        /** @var \hossein142001\notification\components\Push $push */
        $push = Yii::createObject(array_merge(['class' => 'hossein142001\notification\components\Push'], $this->config));

        if(is_array($notification->token)){
            $tokens = $notification->token;
        } else {
            $tokens = [$notification->token];
        }

        foreach ($tokens as $token){
            try {
                $status = $push->ios()->send($token, $notification->push);
            } catch (\Exception $e){
                $this->errors[] = $e->getMessage();
            }

            $this->status[$token] = $status;
        }

        unset($push);
    }
}