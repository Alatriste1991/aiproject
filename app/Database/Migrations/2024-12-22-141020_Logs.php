<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Logs extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'log_id' =>[
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'type' =>[
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'process' =>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'user' =>[
                'type' => 'INT',
                'constraint' => 11,
            ],
            'ip' =>[
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'browser' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'platform' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'info' => [
                'type' => 'TEXT',
            ],
            'admin' =>[
                'type' => 'INT',
                'constraint' => 1,
            ],
            'date' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ]

        ]);
        $this->forge->addKey('log_id', true);
        $this->forge->createTable('logs');
    }

    public function down()
    {
        $this->forge->dropTable('logs');

    }
}
