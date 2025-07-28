<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReviewJasaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'layanan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'komentar' => ['type'  => 'TEXT'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('layanan_id', 'layanan_jasa', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('review');

    }

    public function down()
    {
        $this->forge->dropTable('review');
    }
}
