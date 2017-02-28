<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\AppUser;

class AppUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 30) as $index) {
        	$name = $faker->name();
        	$email = $faker->email();
        	AppUser::create([
        		'fb_id' => "102062298488818".$index,
                'fb_info'=>["id"=> "102062298488818".$index,
   					"birthday"=> "07/10/1991",
   					"email"=> $email,
   					"name"=> $name],
                'api_token'=>str_random(60),
        	]);
        }
    }
}
