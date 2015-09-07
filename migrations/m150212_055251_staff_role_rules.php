<?php

use yii\db\Schema;
use yii\db\Migration;

class m150212_055251_staff_role_rules extends Migration
{
    public function up()
    {
        $this->insert('auth_item', ['name' => 'changeStatus', 'type' => 2, 'description'=> 'Change event status']);
        $this->insert('auth_item_child', ['parent' => 'staff-level1', "child" => 'changeStatus']);
        $this->insert('auth_item_child', ['parent' => 'staff-level2', "child" => 'changeStatus']);

        $this->insert('auth_item', ['name' => 'resetPermission', 'type' => 2, 'description'=> 'Change user role']);
        $this->insert('auth_item_child', ['parent' => 'staff-level1', "child" => 'resetPermission']);

        $this->insert('auth_item', ['name' => 'setRole_staff-level1', 'type' => 2, 'description'=> 'Add staff level1']);
        $this->insert('auth_item_child', ['parent' => 'staff-level1', "child" => 'setRole_staff-level1']);

        $this->insert('auth_item', ['name' => 'setRole_staff-level2', 'type' => 2, 'description'=> 'Add staff level2']);
        $this->insert('auth_item_child', ['parent' => 'staff-level1', "child" => 'setRole_staff-level2']);

        $this->insert('auth_item', ['name' => 'setRole_staff-level3', 'type' => 2, 'description'=> 'Add staff level3']);
        $this->insert('auth_item_child', ['parent' => 'staff-level1', "child" => 'setRole_staff-level3']);
        $this->insert('auth_item_child', ['parent' => 'staff-level2', "child" => 'setRole_staff-level3']);

        $this->insert('auth_item', ['name' => 'setRole_premium', 'type' => 2, 'description'=> 'Add premium user']);
        $this->insert('auth_item_child', ['parent' => 'staff-level1', "child" => 'setRole_premium']);

    }

    public function down()
    {
        echo "m150212_055251_staff_role_rules cannot be reverted.\n";

        return false;
    }
}
