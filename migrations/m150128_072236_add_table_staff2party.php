<?php

use yii\db\Schema;
use yii\db\Migration;

class m150128_072236_add_table_staff2party extends Migration
{
    public function up()
    {
        $this->createTable('staff2party', [
                'id' => Schema::TYPE_PK,
                'party_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            ]);
    }

    public function down()
    {
        $this->dropTable('staff2party');
        return true;
    }
}
