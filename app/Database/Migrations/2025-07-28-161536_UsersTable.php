<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'username'  => ['type'  => 'VARCHAR', 'constraint' => 100],
            'email' => ['type'  => 'VARCHAR', 'constraint' => 150, 'unique' => true],
            'no_handphone' => ['type'  => 'VARCHAR', 'constraint' => 15],
            'avatar_url' => ['type'  => 'VARCHAR', 'constraint' => 200],
            'role' => ['type'  => 'ENUM', 'constraint' => ["admin", "user"]],
            'alamat'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
