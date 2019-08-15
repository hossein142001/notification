<?php

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m171222_202322_create_table_notificatio_status
 */
class m171222_202322_create_table_notification_status extends Migration
{
    public function up()
    {

        $this->createTable('{{%notification_status}}', [
            'id' => $this->primaryKey(),
            'provider' => $this->string(),
            'event' => $this->string(),
            'params' => $this->text(),
            'status' => $this->string()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_user_id' => $this->bigInteger(),
            'updated_at' => $this->timestamp(),
            'updated_user_id' => $this->bigInteger(),
            'deleted_at' => $this->timestamp(),
            'deleted_user_id' => $this->bigInteger(),
        ]);

        $this->addForeignKey('created_user_id_notification_status_fkey', '{{%notification_status}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('updated_user_id_notification_status_fkey', '{{%notification_status}}', 'updated_user_id', '{{%user}}', 'id');
        $this->addForeignKey('deleted_user_id_notification_status_fkey', '{{%notification_status}}', 'deleted_user_id', '{{%user}}', 'id');

    }

    public function down()
    {
        $this->dropTable('{{%notification_status}}');
    }
}
