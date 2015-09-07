<?php

use yii\db\Schema;
use yii\db\Migration;

class m150225_132440_change_table_ticket extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'status', Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 1');
    }

    public function down()
    {
        echo "m150225_132440_change_table_ticket cannot be reverted.\n";

        return false;
    }
}
