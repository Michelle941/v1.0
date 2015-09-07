<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_102947_message extends Migration
{
    public function up()
    {
        $this->createTable('message', [
            'id' => Schema::TYPE_PK,
            're_id' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'user_from' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_to' => Schema::TYPE_INTEGER . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'text' => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'read_at' => Schema::TYPE_INTEGER. ' NOT NULL',
        ]);
    }
    public function down()
    {
        $this->dropTable('message');
        return true;
    }
}
