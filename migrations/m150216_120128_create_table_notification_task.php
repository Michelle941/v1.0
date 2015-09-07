<?php

use yii\db\Schema;
use yii\db\Migration;

class m150216_120128_create_table_notification_task extends Migration
{
    public function up()
    {
        $this->createTable('notification_task', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'from_user' => Schema::TYPE_INTEGER. ' NOT NULL',
            'user_list' => Schema::TYPE_TEXT . ' NOT NULL',
            'value' => Schema::TYPE_STRING,
            'dop_value' => Schema::TYPE_STRING
        ]);
    }

    public function down()
    {
        $this->dropTable('notification_task');
        return false;
    }
}
