<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
                [
                    "name" => "Admin",
                    "description" => "All Access"
                ],
                [
                    "name" => "User",
                    "description" => "Access View and Edit"
                ]
            ];
        
        foreach ($roles as $role) {
            Role::create($role);
        }

        $users = [
                [
                    "email" => "admin@test.com",
                    "name" => "Admin",
                    "password" => Hash::make("password"),
                    "role_id" => 1
                ],
                [
                    "email" => "user@test.com",
                    "name" => "User",
                    "password" => Hash::make("password"),
                    "role_id" => 2
                ]
            ];

        foreach($users as $user) {
            User::create($user);
        }
    }
}
