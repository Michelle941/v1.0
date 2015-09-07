<?php

use yii\db\Schema;
use yii\db\Migration;

class m150412_123939_users_settings extends Migration
{
    public function up()
    {
        $this->createTable('user_settings', [
            'id'     => Schema::TYPE_PK,
            'user_id'=> Schema::TYPE_INTEGER. ' NOT NULL',
            'name'   => Schema::TYPE_STRING . ' NOT NULL',
            'value'  => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('user_settings');
        return true;
    }
}
