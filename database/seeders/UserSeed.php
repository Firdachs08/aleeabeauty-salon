<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('123'),
                'role' => 'admin',
                //'phone' => '1234567890',
                'remember_token' => null,
            ],
           
        ];

        User::insert($users);
    }
}
