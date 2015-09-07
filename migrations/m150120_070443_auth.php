<?php

use yii\db\Schema;
use yii\db\Migration;

class m150120_070443_auth extends Migration
{
    public function up()
    {
        $this->createTable('auth', [
                'id' => Schema::TYPE_PK,
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'source' => Schema::TYPE_STRING . ' NOT NULL',
                'source_id' => Schema::TYPE_STRING . ' NOT NULL',
            ]);
    }

    public function down()
    {
        $this->dropTable('auth');
        return true;
    }
}
