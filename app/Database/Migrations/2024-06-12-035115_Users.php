<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'NO_BUKTI_POTONG' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
                'unique' => true,
            ],
            'NAMA_PENERIMA_PENGHASILAN' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'ID_SISTEM' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'NIK' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'TAHUN' => [
                'type' => 'YEAR',
                'null' => false,
            ],
            'BULAN' => [
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('NO_BUKTI_POTONG', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
