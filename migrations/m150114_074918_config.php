<?php

use yii\db\Schema;
use yii\db\Migration;

class m150114_074918_config extends Migration
{
    public function up()
    {
        $this->createTable('config', [
                'id'     => Schema::TYPE_PK,
                'group'  => Schema::TYPE_STRING . ' NOT NULL',
                'name'   => Schema::TYPE_STRING . ' NOT NULL',
                'value'  => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('config');
        return true;
    }
}
