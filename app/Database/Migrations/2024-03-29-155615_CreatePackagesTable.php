<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePackagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'package_id'=> [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'package_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'package_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => FALSE,
                'default' => 0.00
            ],
            'picture_qty' => [
                'type' => 'INT',
                'constraint' => 3,
            ],
            'status' => [
                'type' => 'boolean',
            ],
        ]);
        $this->forge->addKey('package_id', true);
        $this->forge->createTable('packages');
    }

    public function down()
    {
        $this->forge->dropTable('packages');
    }
}
