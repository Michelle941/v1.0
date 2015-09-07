<?php

use yii\db\Schema;
use yii\db\Migration;

class m150212_085339_create_table_user_group extends Migration
{
    public function up()
    {
        $this->createTable('user_group', [
                'id' => Schema::TYPE_PK,
                'title' => Schema::TYPE_STRING . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER. ' NOT NULL',
            ]);

        $this->createTable('user2group', [
                'id' => Schema::TYPE_PK,
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'group_id' => Schema::TYPE_INTEGER . ' NOT NULL'
            ]);
    }

    public function down()
    {
        $this->dropTable('user_group');
        $this->dropTable('user2group');
        return true;
    }
}
