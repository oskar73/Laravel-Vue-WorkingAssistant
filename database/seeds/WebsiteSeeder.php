<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 300) as $index) {
            App\Models\Website::create([
                'user_id' => $faker->randomDigit(),
                'domain' => $faker->domainName(),
                'name' => $faker->name(),
                'status' => rand(0, 1) ? 'active' : 'pending',
            ]);
        }
    }
}
