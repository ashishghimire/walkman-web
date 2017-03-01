<?php

use Illuminate\Database\Seeder;
use App\AppUser;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppUser::truncate();
        User::truncate();

        $this->call(AppUsersTableSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
