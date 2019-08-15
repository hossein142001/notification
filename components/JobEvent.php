<?php

namespace hossein142001\notification\components;

use hossein142001\queue\models\MessageModel;
use yii\base\Event;

/**
 * Class JobEvent
 * @package hossein142001\notification\components
 */
class JobEvent extends Event
{
    /**
     * @var string|null unique id of a job
     */
    public $provider;

    /**
     * @var string|null unique id of an event
     */
    public $event;

    /**
     * @var array
     */
    public $params = [];

    /**
     * @var array
     */
    public $status = [];

    /**
     * @var array
     */
    public $errors = [];

    /**
     * @var boolean whether to continue send messages. Event handlers of
     * [[\hossein142001\notification\Module::EVENT_BEFORE_SEND]] may set this property to decide whether
     * to continue running the send message.
     */
    public $isValid = true;

}