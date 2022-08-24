<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
               // ADMIN
               User::create([
                'role_id'           => 1,
                'email'             => 'admin@prodev.com',
                'password'          => bcrypt('123456'),
                'username'          => 'Administrator',
                'first_name'        => 'David',
                'last_name'         => 'Egbochuo',
                'phone_number'      => '08163394819',
                'email_verified_at' => now(),
            ]);


            // USER
            User::create([
                'role_id'           => 2,
                'email'             => 'hope_cyf@prodev.com',
                'password'          => bcrypt('123456'),
                'username'          => 'Hopercy',
                'first_name'        => 'Hope',
                'last_name'         => 'Cyfadas',
                'phone_number'      => '081198728371',
                'email_verified_at' => now(),
            ]);

            // Generate 7 other client users
            User::factory(7)->create();
    }
}
