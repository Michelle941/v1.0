<?php

use yii\db\Schema;
use yii\db\Migration;

class m150704_220841_party_ranking extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'rank', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        echo "m150704_220841_party_ranking cannot be reverted.\n";

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
