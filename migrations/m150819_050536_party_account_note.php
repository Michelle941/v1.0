<?php

use yii\db\Schema;
use yii\db\Migration;

class m150819_050536_party_account_note extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'account_note', Schema::TYPE_TEXT);
    }

    public function down()
    {
        echo "m150819_050536_party_account_note cannot be reverted.\n";

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
