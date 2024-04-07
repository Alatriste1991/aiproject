<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderPaymentAddress extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'order_payment_address_id'  => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'order_id'  => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'order_payment_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_payment_country'=> [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_payment_county' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_payment_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_payment_city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_payment_address' => [
                'type' => 'TEXT',
            ],
        ]);
        $this->forge->addKey('order_payment_address_id', true);
        $this->forge->createTable('order_payment_address');
    }

    public function down()
    {
        $this->forge->dropTable('order_payment_address');
    }
}
