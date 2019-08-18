<?php

namespace hossein142001\notification\models;

use hiiran\api\v1\modules\domain\models\Domain;
use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use hiiran\api\v1\modules\user\models\User;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property string $event
 * @property string $provider
 * @property string $status_id
 * @property string $title
 * @property string $message
 * @property string $params
 * @property string $update_at
 * @property string $create_at
 */
class Message extends \hiiran\components\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_id', 'to_id', 'status_id'], 'integer'],
            [['message', 'params', 'provider'], 'string'],
            [['update_at', 'create_at'], 'safe'],
            [['title', 'provider'], 'string', 'max' => 255],
            [['event'], 'string', 'max' => 100],

            [['from_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_id' => 'id']],
            [['to_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_id' => 'id']],

            [['created_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_user_id' => 'id']],
            [['updated_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_user_id' => 'id']],
            [['deleted_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['deleted_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_id' => 'From Id',
            'to_id' => 'To Id',
            'event' => 'Event name',
            'provider' => 'provider',
            'status_id' => 'status',
            'title' => 'Title',
            'message' => 'Message',
            'params' => 'Json params',
            'update_at' => 'Update At',
            'create_at' => 'Create At',
        ];
    }

    /**
     * @param array $where
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function messages($where = [])
    {
        if (!$where) {
            $where = ['or', 'to_id' => Yii::$app->user->identity->id, 'from_id' => Yii::$app->user->identity->id];
        }

        return self::find()->where($where)->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Domain::className(), ['id' => 'status_id']);
    }

    /**
     * @param array $params
     */
    public function setParams($params = [])
    {
        $params = ArrayHelper::merge($this->attributes, $params);
        $this->params = Json::encode($params);
    }

    /**
     * @return array|mixed
     */
    public function getParams()
    {
        $params = Json::decode($this->getAttribute('params'));
        if (!$params) {
            $params = [];
        }
        return $params;
    }

    /**
     * @param string $name
     * @return array|mixed
     * @throws Exception
     */
    public function __get($name)
    {

        if ($name == 'attributes') {
            return $this->getAttributes();
        }

        // If name is model attribute
        $attributes = $this->attributes();
        if (in_array($name, $attributes)) {
            return parent::__get($name);
        }

        // If name is param of model`s attribute by name params
        $params = $this->getParams();
        if (isset($params[$name])) {
            return $params[$name];
        }

        throw new Exception();

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'created_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeletedUser()
    {
        return $this->hasOne(User::className(), ['id' => 'deleted_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_id']);
    }
}
