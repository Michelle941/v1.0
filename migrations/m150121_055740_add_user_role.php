<?php

use yii\db\Schema;
use yii\db\Migration;

class m150121_055740_add_user_role extends Migration
{
    public function up()
    {
        $this->insert('auth_item', ['name' => 'user', 'type' => 1, 'description'=> 'Base user']);
        $this->insert('auth_item', ['name' => 'premium', 'type' => 1, 'description'=> 'Premium user']);
        $this->insert('auth_item', ['name' => 'staff-level1', 'type' => 1, 'description'=> 'Staff level 1']);
        $this->insert('auth_item', ['name' => 'staff-level2', 'type' => 1, 'description'=> 'Staff level 2']);
        $this->insert('auth_item', ['name' => 'staff-level3', 'type' => 1, 'description'=> 'Staff level 3']);
    }

    public function down()
    {
        echo "m150121_055740_add_user_role cannot be reverted.\n";

        return false;
    }
}
