<?php

namespace hossein142001\notification\commands;

use hossein142001\notification\components\Notification;
use Yii;
use yii\console\Controller;

/**
 * NotificationController
 */
class NotificationController extends Controller
{
    public function actionSend($triggerClass, $name, array $data = [])
    {
        if(empty($data)){
            return;
        }

        Yii::$app->db->close();
        $notification = new Notification($data);
        Notification::trigger($triggerClass, $name, $notification);
    }
}
