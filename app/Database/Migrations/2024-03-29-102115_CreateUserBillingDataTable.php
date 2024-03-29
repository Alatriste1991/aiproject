<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserBillingDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'billing_data_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'billing_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'billing_country'=> [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'billing_county' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'billing_code' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'billing_city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'billing_address' => [
                'type' => 'TEXT',
            ],
            'default' => [
                'type' => 'boolean',
            ],
        ]);
        $this->forge->addKey('billing_data_id', true);
        $this->forge->createTable('user_billing_data');
    }

    public function down()
    {
        $this->forge->dropTable('user_billing_data');
    }
}
