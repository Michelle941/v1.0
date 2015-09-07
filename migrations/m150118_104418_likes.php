<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_104418_likes extends Migration
{
    public function up()
    {
        $this->createTable('likes', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'photo_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('likes');
        return true;
    }
}
