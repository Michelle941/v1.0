<?php
use yii\db\Schema;
use yii\db\Migration;

class m160321_024142_dashboard_party extends Migration
{
    public function up()
    {
        $this->addColumn('party', 'on_dashboard', Schema::TYPE_INTEGER);
        $this->addColumn('party', 'yes', Schema::TYPE_STRING);
        $this->addColumn('party', 'no', Schema::TYPE_STRING);

    }

    public function down()
    {
        echo "m160321_024142_dashboard_party cannot be reverted.\n";

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
