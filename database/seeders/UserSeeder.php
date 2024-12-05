<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Bouncer;

class UserSeeder extends Seeder
{
    public function run()
    {

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$12$1kQ6ggkKMARm/cA6/FL8BeNZeSnOcYSyiaCzAuJNS/dc3PZOmuzom',
        ]);

        $user = User::create([
            'name' => 'user1',
            'email' => 'user@gmail.com',
            'password' => '$2y$12$pDcOx2o7RyWpzMTZIG4e4Ogf1Rw7apVcbS0yHrTWTx3qhkMd4CfCW',
        ]);

        Bouncer::assign('admin')->to($admin);
        Bouncer::assign('user')->to($user);
    }
}
