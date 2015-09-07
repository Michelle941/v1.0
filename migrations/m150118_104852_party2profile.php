<?php

use yii\db\Schema;
use yii\db\Migration;

class m150118_104852_party2profile extends Migration
{
    public function up()
    {
        $this->createTable('party2profile', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'party_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
        ]);
    }
    public function down()
    {
        $this->dropTable('party2profile');
        return true;
    }
}
