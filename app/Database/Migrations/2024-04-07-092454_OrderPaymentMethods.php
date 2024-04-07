<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderPaymentMethods extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'payment_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'payment_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
        ]);
        $this->forge->addKey('payment_id', true);
        $this->forge->createTable('order_payment_methods');
    }

    public function down()
    {
        $this->forge->dropTable('order_payment_methods');
    }
}
