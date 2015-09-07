<?php

use yii\db\Schema;
use yii\db\Migration;

class m150202_153054_update_table_message extends Migration
{
    public function up()
    {
        $this->alterColumn('message', 'status', Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 0');
        $this->alterColumn('message', 'read_at', Schema::TYPE_INTEGER . ' DEFAULT NULL');
    }

    public function down()
    {
        echo "m150202_153054_update_table_message cannot be reverted.\n";

        return false;
    }
}
