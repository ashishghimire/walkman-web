<?php

use Illuminate\Database\Seeder;
use App\AppUser;

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
        $this->call(AppUsersTableSeeder::class);
    }
}
