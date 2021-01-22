<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectoryAdsPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('directory_ads_positions')->truncate();

        $positions = [
            ['position_id' => 1, 'name' => 'Top area (right below of directory navigation bar)', 'type' => 'ads'],
            ['position_id' => 2, 'name' => 'Middle area (between category and listing area)', 'type' => 'ads'],
            ['position_id' => 3, 'name' => 'Bottom area (right above of footer)', 'type' => 'ads'],
            ['position_id' => 4, 'name' => 'Left top sponsored area', 'type' => 'ads'],
            ['position_id' => 5, 'name' => 'Left bottom sponsored area', 'type' => 'ads'],
            ['position_id' => 6, 'name' => 'Right top sponsored area', 'type' => 'ads'],
            ['position_id' => 7, 'name' => 'Right bottom sponsored area', 'type' => 'ads'],
            ['position_id' => 8, 'name' => 'First sponsored Listing area', 'type' => 'listing'],
            ['position_id' => 9, 'name' => 'Fifth sponsored listing area', 'type' => 'listing'],
        ];

        foreach ($positions as $position) {
            \App\Models\DirectoryAdsPosition::create($position);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Model::reguard();
    }
}
