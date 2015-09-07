<?php

use yii\db\Schema;
use yii\db\Migration;

class m150119_064958_change_party extends Migration
{
    public function up()
    {
        $this->dropColumn('party', 'flayer');
        $this->dropColumn('party', 'ticket_total');
        $this->dropColumn('party', 'base_price');
        $this->dropColumn('party', 'date');
    }

    public function down()
    {
        echo "m150119_064958_change_party cannot be reverted.\n";

        return false;
    }
}
