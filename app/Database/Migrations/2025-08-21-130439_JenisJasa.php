<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JenisJasaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'nama_jenisjasa' => ['type'  => 'VARCHAR', 'constraint' => 255],
            'icon' => ['type'  => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');


        $this->forge->createTable('jenis_jasa');

    }

    public function down()
    {
        $this->forge->dropTable('jenis_jasa');
    }
}
