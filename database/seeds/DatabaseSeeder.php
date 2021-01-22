<?php

use Database\Seeders\DirectoryAdsPositionSeeder;
use Database\Seeders\DirectoryAdsTypeSeeder;
use Database\Seeders\NotificationSeeder;
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
        $this->call(RoleSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(BlogAdsTypeSeeder::class);
        $this->call(SiteAdsTypeSeeder::class);
        $this->call(BlogAdsPositionSeeder::class);
        $this->call(DirectoryAdsTypeSeeder::class);
        $this->call(DirectoryAdsPositionSeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
