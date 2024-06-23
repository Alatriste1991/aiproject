<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Admins extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'admin_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'admin_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'admin_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'admin_password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'admin_status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
            ],
            'admin_created_time' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('admin_id', true);
        $this->forge->createTable('admins');
    }

    public function down()
    {
        $this->forge->dropTable('admins');
    }
}
