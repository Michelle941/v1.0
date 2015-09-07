<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_104303_following extends Migration
{
    public function up()
    {
        $this->createTable('following', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'follow_to' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
        ]);
    }
    public function down()
    {
        $this->dropTable('following');
        return true;
    }
}
