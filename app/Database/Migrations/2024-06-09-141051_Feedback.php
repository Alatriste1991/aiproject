<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Feedback extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'feedback_id' => [
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
            'feedback_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'feedback_text' => [
                'type' => 'TEXT',
            ],
            'created_time' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('feedback_id', true);
        $this->forge->createTable('feedback');
    }

    public function down()
    {
        $this->forge->dropTable('feedback');
    }
}
