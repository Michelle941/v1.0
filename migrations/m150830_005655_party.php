<?php

use yii\db\Schema;
use yii\db\Migration;

class m150830_005655_party extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'manager_password', Schema::TYPE_SMALLINT);
    }

    public function down()
    {
        echo "m150830_005655_party cannot be reverted.\n";

        return false;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
