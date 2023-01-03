<?php

namespace Database\Seeders;

use DB;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $faker = Faker::create();
        foreach(range(79,2000) as $index){
            DB::table('users')->insert([
                'name'=>$faker->name,
                'phone'=>$faker->phone,
                'password'=>$faker->password
            ]);
        }
    }
}
