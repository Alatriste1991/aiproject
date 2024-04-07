<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserGeneratingCount extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'count' => [
                'type' => 'TINYINT',
                'constraint' => 5,
            ],
        ]);
        $this->forge->createTable('user_generating_count');
        $this->forge->addKey('user_id', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_generating_count');
    }
}
