<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Bugs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'bug_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'assigned_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'bug_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'bug_description' => [
                'type' => 'TEXT',
            ],
            'priority' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_time' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('bug_id', true);
        $this->forge->createTable('bugs');
    }

    public function down()
    {
       $this->forge->dropTable('bugs');
    }
}
