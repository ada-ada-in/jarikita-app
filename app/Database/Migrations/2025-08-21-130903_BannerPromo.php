<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BannerPromoTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => ['type'  => 'INT', 'constraint' => 11, 'auto_increment' => true, 'unsigned' => true],
            'image_link' => ['type'  => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);


        $this->forge->addPrimaryKey('id');


        $this->forge->createTable('banner_promo');

    }

    public function down()
    {
        $this->forge->dropTable('banner_promo');
    }
}
