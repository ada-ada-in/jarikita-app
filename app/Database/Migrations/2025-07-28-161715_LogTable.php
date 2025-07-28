<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'deskripsi'    => ['type' => 'TEXT'],
            'email' => ['type'  => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'no_handphone' => ['type'  => 'VARCHAR', 'constraint' => 15],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('log');
    }

    public function down()
    {
        $this->forge->dropTable('log');
    }
}
