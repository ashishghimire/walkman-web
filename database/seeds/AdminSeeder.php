<?php

use Illuminate\Database\Seeder;
use App\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(empty(env('ADMIN_NAME')) || empty(env('ADMIN_EMAIL')) || empty(env('ADMIN_PASSWORD'))) {
            echo "ERROR!! Make sure ADMIN_NAME, ADMIN_EMAIL and ADMIN_PASSWORD in your .env file is not empty\n";
            die();
        }

        User::create([
        	'name' => trim(env('ADMIN_NAME')),
        	'email' => trim(env('ADMIN_EMAIL')),
        	'password'=> bcrypt(trim(env('ADMIN_PASSWORD'))),
        	'role' => 'admin',
        ]);
    }
}
