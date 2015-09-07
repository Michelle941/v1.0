<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_102708_comments extends Migration
{
    public function up()
    {
        $this->createTable('comments', [
            'id' => Schema::TYPE_PK,
            'photo_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER.' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            'text'   => Schema::TYPE_TEXT . ' NOT NULL',
        ]);
    }
    public function down()
    {
        $this->dropTable('comments');
        return true;
    }
}
