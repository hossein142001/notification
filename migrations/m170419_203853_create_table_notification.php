<?php

use yii\db\Expression;
use yii\db\Migration;

class m170419_203853_create_table_notification extends Migration
{
    public function up()
    {

        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'from_id' => $this->bigInteger(),
            'to_id' => $this->bigInteger(),
            'title' => $this->string(255),
            'message' => $this->text(),
            'params' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_user_id' => $this->bigInteger(),
            'updated_at' => $this->timestamp(),
            'updated_user_id' => $this->bigInteger(),
            'deleted_at' => $this->timestamp(),
            'deleted_user_id' => $this->bigInteger(),
        ]);

        $this->addForeignKey('from_id_notification_fkey', '{{%notification}}', 'from_id', '{{%user}}', 'id');
        $this->addForeignKey('to_id_notification_fkey', '{{%notification}}', 'to_id', '{{%user}}', 'id');

        $this->addForeignKey('created_user_id_notification_fkey', '{{%notification}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('updated_user_id_notification_fkey', '{{%notification}}', 'updated_user_id', '{{%user}}', 'id');
        $this->addForeignKey('deleted_user_id_notification_fkey', '{{%notification}}', 'deleted_user_id', '{{%user}}', 'id');

    }

    public function down()
    {
        $this->dropTable('{{%notification}}');
    }

}
