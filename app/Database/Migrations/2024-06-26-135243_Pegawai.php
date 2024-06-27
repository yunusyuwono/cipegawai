<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'idpegawai' =>[
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ]
            ]);
            $this->forge->addKey('idpegawai', true);
            $this->forge->createTable('datapegawai');
    }

    public function down()
    {
        $this->forge->dropTable('datapegawai');
    }
}