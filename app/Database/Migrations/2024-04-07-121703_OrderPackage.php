<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderPackage extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_package_id'  => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id'  => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'order_p_package_id'=> [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'order_package_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_package_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00
            ],
            'order_picture_qty' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
        ]);
        $this->forge->addKey('order_package_id', true);
        $this->forge->createTable('order_package');
    }

    public function down()
    {
        $this->forge->dropTable('order_package');
    }
}
