<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                "nom" => "John",
                "prenom" => "Doe",
                "email" => "admin@mail.test",
                "telephone" => "123456789",
                "is_active" => true,
                "password" => bcrypt("password"),
                "can_login" => true,
                "email_verified_at" => now()
            ]
        ];

        $this->createAdmins($admins);

        $clients = [
            [
                "nom" => "Jack",
                "prenom" => "Doe",
                "email" => "client@mail.test",
                "telephone" => "323456789",
                "is_active" => true,
                "password" => bcrypt("password"),
                "can_login" => true,
                "email_verified_at" => now()
            ]
        ];
        $this->createClients($clients);
    }

    public function createAdmins(array $admins)
    {
        foreach ($admins as $admin) {

            $user = User::create($admin);

            $user->roles()->attach(Role::where('alias', Role::ADMIN_ROLE_ALIAS)->first()->id);
        }
    }

    public function createControllers(array $controllers)
    {
        foreach ($controllers as $controller) {

            $user = User::create($controller);

            $user->roles()->attach(Role::where('alias', Role::CONTROLLER_ROLE_ALIAS)->first()->id);
        }
    }

    public function createClients(array $clients)
    {
        foreach ($clients as $client) {

            $user = User::create($client);

            $user->roles()->attach(Role::where('alias', Role::CLIENT_ROLE_ALIAS)->first()->id);
        }
    }
}
