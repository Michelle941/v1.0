<?php

use yii\db\Schema;
use yii\db\Migration;

class m150208_135432_notification extends Migration
{
    public function up()
    {
        $this->createTable('notification', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'object_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'type' => Schema::TYPE_SMALLINT. ' NOT NULL', // тип уведомления
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'is_read'  => Schema::TYPE_BOOLEAN.' NOT NULL DEFAULT 0'
        ]);
    }
    public function down()
    {
        $this->dropTable('ticket');
        return true;
    }
}
