<?php

namespace App\Database\Seeds;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $email = strtolower("admin@example.com");
        $password = "adminpassword";

        if ($email === '' || $password === '') {
            CLI::error('SEED_ADMIN_EMAIL and SEED_ADMIN_PASSWORD must be set.');
            return;
        }

        $users = new UserModel();

        if ($users->where('email', $email)->first()) {
            CLI::write('Admin already exists, skipping.');
            return;        
        }

        $users->save(new User([
            'name'      => "Administrator",
            'email'     => $email,
            'password'  => $password,
            'role'      => 'admin',
        ]));

        CLI::write("Admin created: {$email}");
    }
}
