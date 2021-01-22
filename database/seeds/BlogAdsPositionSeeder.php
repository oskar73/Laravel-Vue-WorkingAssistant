<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class BlogAdsPositionSeeder extends Seeder
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

        DB::table('blog_ads_positions')->truncate();

        $positions = [
            ['position_id' => 1, 'name' => 'Featured Area Top Right Sponsored Box', 'type' => 'home'],
            ['position_id' => 2, 'name' => 'Featured Area Bottom Left Sponsored Box', 'type' => 'home'],
            ['position_id' => 3, 'name' => 'Recent News Area Top Banner', 'type' => 'home'],
            ['position_id' => 4, 'name' => 'Right Top Sponsored Box', 'type' => 'home'],
            ['position_id' => 5, 'name' => 'All Posts Area Top Banner', 'type' => 'home'],
            ['position_id' => 6, 'name' => 'All Posts Top Left Sponsored Box', 'type' => 'home'],
            ['position_id' => 7, 'name' => 'All Posts Top Right Sponsored Box', 'type' => 'home'],
            ['position_id' => 8, 'name' => 'Right Middle Sponsored Box', 'type' => 'home'],
            ['position_id' => 9, 'name' => 'Right Bottom Sponsored Box', 'type' => 'home'],
            ['position_id' => 10, 'name' => 'Left Sidebar Banner', 'type' => 'home'],
            ['position_id' => 11, 'name' => 'Right Sidebar Banner', 'type' => 'home'],

            ['position_id' => 12, 'name' => 'Top Right Sponsored Box', 'type' => 'category'],
            ['position_id' => 13, 'name' => 'Middle Right Sponsored Box', 'type' => 'category'],
            ['position_id' => 14, 'name' => 'Bottom Right Sponsored Box', 'type' => 'category'],
            ['position_id' => 15, 'name' => 'Post Area Right Sponsored Box', 'type' => 'category'],
            ['position_id' => 16, 'name' => 'Post Area Left Sponsored Box', 'type' => 'category'],
            ['position_id' => 17, 'name' => 'Left Sidebar Banner', 'type' => 'category'],
            ['position_id' => 18, 'name' => 'Right Sidebar Banner', 'type' => 'category'],
            ['position_id' => 19, 'name' => 'Top Banner', 'type' => 'category'],

            ['position_id' => 20, 'name' => 'Top Right Sponsored Box', 'type' => 'detail'],
            ['position_id' => 21, 'name' => 'Middle Right Sponsored Box', 'type' => 'detail'],
            ['position_id' => 22, 'name' => 'Bottom Right Sponsored Box', 'type' => 'detail'],
            ['position_id' => 23, 'name' => 'Top Banner', 'type' => 'detail'],
            ['position_id' => 24, 'name' => 'Bottom Banner', 'type' => 'detail'],
            ['position_id' => 25, 'name' => 'Left Sidebar Banner', 'type' => 'detail'],
            ['position_id' => 26, 'name' => 'Right Sidebar Banner', 'type' => 'detail'],
            ['position_id' => 27, 'name' => 'Comment Area Right Sponsored Box', 'type' => 'detail'],
        ];

        foreach ($positions as $position) {
            \App\Models\BlogAdsPosition::create($position);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Model::reguard();
    }
}
