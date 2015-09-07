<?php

use yii\db\Schema;
use yii\db\Migration;

class m150205_063748_change_photo_table extends Migration
{
    public function up()
    {
        $this->addColumn('photo', 'party_id', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn('photo', 'comment', Schema::TYPE_STRING . ' NOT NULL DEFAULT ""');
        $this->addColumn('photo', 'status', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 0'); //модерация
    }

    public function down()
    {
        echo "m150205_063748_change_photo_table cannot be reverted.\n";

        return false;
    }
}
