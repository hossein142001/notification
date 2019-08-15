<?php

use hossein142001\notification\Module;
use hossein142001\notification\components\JobEvent;
use hossein142001\notification\components\Notification;
use hossein142001\notification\models\NotificationStatus;

class ComponentsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $notification;

    protected $checkEvent = false;

    protected function _before()
    {
        /* @var \common\modules\notification\Module $notification */
        $this->notification = \Yii::$app->getModule('notification');

        $this->notification->on(Module::EVENT_BEFORE_SEND, function (JobEvent $event){
            $this->checkEvent = true;
        });
    }

    protected function _after()
    {
        \Yii::$app->db->createCommand()->truncateTable('notification_status')->execute();
    }

    public function testCheckEvent()
    {

        $data = [
            'name' => 'simple',
            'from' => \Yii::$app->params[ 'noreplyEmail' ],
            'to' => \Yii::$app->params[ 'noreplyEmail' ],
            'content' => '',
            'subject' => "Test subject",
            'path' => '@app/mail',
            'view' => ['html' => 'simple-html', 'text' => 'simple-text'],
            'layouts' => [
                'text' => '@app/mail/layouts/text',
                'html' => '@app/mail/layouts/html',
            ],
            'params' => [
                'content_subject' => 'Test subject',
            ],
            'data' => [
                'providerName' => 'notify',
            ],
        ];
        $this->notification->sendEvent(new Notification($data));
        $this->assertNotFalse($this->checkEvent);
    }

    public function testCheckStatus()
    {
        $data = [
            'name' => 'simple',
            'from' => \Yii::$app->params[ 'noreplyEmail' ],
            'to' => \Yii::$app->params[ 'noreplyEmail' ],
            'content' => '',
            'subject' => "Test subject",
            'path' => '@app/mail',
            'view' => ['html' => 'simple-html', 'text' => 'simple-text'],
            'layouts' => [
                'text' => '@app/mail/layouts/text',
                'html' => '@app/mail/layouts/html',
            ],
            'params' => [
                'content_subject' => 'Test subject',
            ],
            'data' => [
                'providerName' => 'notify',
            ],
        ];
        $this->notification->sendEvent(new Notification($data));
        $this->assertNotEmpty(NotificationStatus::find()->one());
    }
}