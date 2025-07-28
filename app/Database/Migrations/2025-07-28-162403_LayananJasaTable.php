<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class LayananJasaTable extends Migration
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
            'lokasi_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true
            ],
            'nama_jasa' => ['type'  => 'VARCHAR', 'constraint' => 100],
            'alamat' => ['type'  => 'VARCHAR', 'constraint' => 200],
            'deskripsi' => ['type'  => 'TEXT'],
            'image_url' => ['type'  => 'VARCHAR', 'constraint' => 200],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lokasi_id', 'lokasi', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('layanan_jasa');

    }

    public function down()
    {
        $this->forge->dropTable('layanan_jasa');
    }
}
