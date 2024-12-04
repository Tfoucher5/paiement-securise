<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Bouncer;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Création des utilisateurs avec des mots de passe sécurisés
        $adminPassword = 'F@st$ecur3Adm1n!2024';
        $userPassword = 'Str0ng!Us3rP@ssw0rd2024';
        // Création de l'utilisateur admin
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt($adminPassword),
        ]);

        $user = User::create([
            'name' => 'user1',
            'email' => 'user@gmail.com',
            'password' => bcrypt($userPassword),
        ]);

        Bouncer::assign('admin')->to($admin);
        Bouncer::assign('user')->to($user);

        echo "Admin Password (non crypté): $adminPassword\n";
        echo "User Password (non crypté): $userPassword\n";
    }
}
