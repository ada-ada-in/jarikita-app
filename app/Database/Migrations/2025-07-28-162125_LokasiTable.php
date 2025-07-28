<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LokasiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'lokasi' => ['type'  => 'VARCHAR', 'constraint' => 255, 'unique' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('lokasi');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi');
    }
}
