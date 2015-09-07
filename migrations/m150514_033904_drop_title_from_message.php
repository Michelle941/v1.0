<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_033904_drop_title_from_message extends Migration
{
    public function up()
    {
        $this->dropColumn('message', 'title');
    }

    public function down()
    {
        echo "m150514_033904_drop_title_from_message cannot be reverted.\n";

        return false;
    }
}
