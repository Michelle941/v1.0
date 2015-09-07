<?php

use yii\db\Schema;
use yii\db\Migration;

class m150816_013250_update_notification extends Migration
{
    public function up()
    {
        $this->addColumn('notification', 'subtype', Schema::TYPE_SMALLINT);
    }

    public function down()
    {
        echo "m150816_013250_update_notification cannot be reverted.\n";

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
