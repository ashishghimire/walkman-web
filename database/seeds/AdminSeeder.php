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
        User::create([
        	'name' => 'Ashish',
        	'email' => 'ashishghimire02@gmail.com',
        	'password'=> bcrypt('nice2meetu'),
        	'role' => 'admin',
        ]);
    }
}
