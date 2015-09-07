<?php

use yii\db\Schema;
use yii\db\Migration;

class m150401_135704_add_transaction_id_in_ticket extends Migration
{
    public function up()
    {
        $this->addColumn('ticket', 'transaction_id', Schema::TYPE_STRING);
        $this->dropColumn('ticket', 'price');
    }

    public function down()
    {
        echo "m150401_135704_add_transaction_id_in_ticket cannot be reverted.\n";

        return false;
    }
}
