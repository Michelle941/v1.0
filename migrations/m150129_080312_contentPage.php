<?php

use yii\db\Schema;
use yii\db\Migration;

class m150129_080312_contentPage extends Migration
{
    public function up()
    {
        $this->createTable('page', [
                'id' => Schema::TYPE_PK,
                'url' => Schema::TYPE_STRING . ' NOT NULL',
                'title' => Schema::TYPE_STRING . ' NOT NULL',
                'text' => Schema::TYPE_TEXT. ' NOT NULL',
            ]);
    }

    public function down()
    {
        $this->dropTable('page');
        return true;
    }
}
