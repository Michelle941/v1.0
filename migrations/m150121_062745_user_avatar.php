<?php

use yii\db\Schema;
use yii\db\Migration;

class m150121_062745_user_avatar extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'avatar', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
    }

    public function down()
    {
        echo "m150121_062745_user_avatar cannot be reverted.\n";

        return false;
    }
}
