<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRefreshTokenColumnOnUserTable extends Migration
{
public function up()
{
    $this->forge->addColumn('users', [
        'email_verified_at' => [
            'type'  => 'DATETIME',
            'null'  => true,
            'after' => 'email',
        ],
    ]);

    $this->forge->addColumn('users', [
        'refresh_token' => [
            'type'       => 'VARCHAR',
            'constraint' => 255,
            'null'       => true,
            'after'      => 'role',
        ],
    ]);

    $this->forge->addColumn('users', [
        'refresh_token_expires_at' => [
            'type'  => 'DATETIME',
            'null'  => true,
            'after' => 'refresh_token',
        ],
    ]);
}

    public function down()
    {
        $this->forge->dropColumn('users', 'email_verified_at');
        $this->forge->dropColumn('users', 'refresh_token');
        $this->forge->dropColumn('users', 'refresh_token_expires_at');        
    }
}
