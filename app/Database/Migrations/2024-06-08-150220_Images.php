<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Images extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'image_url_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'image' => [
                'type' => 'LONGTEXT',
            ],
            'prompt' => [
                'type' => 'TEXT',
            ],
            'created_time' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('image_url_id', true);
        $this->forge->createTable('images');
    }

    public function down()
    {
        $this->forge->dropTable('images');
    }
}
