<?php

use yii\db\Schema;
use yii\db\Migration;

class m150410_163624_users_photo extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'photo1', Schema::TYPE_STRING);
        $this->addColumn('user', 'photo2', Schema::TYPE_STRING);
        $this->addColumn('user', 'photo3', Schema::TYPE_STRING);
        $this->addColumn('user', 'photo4', Schema::TYPE_STRING);
    }

    public function down()
    {
        echo "m150410_163624_users_photo cannot be reverted.\n";

        return false;
    }
}
