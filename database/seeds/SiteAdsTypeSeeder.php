<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SiteAdsTypeSeeder extends Seeder
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

        DB::table('site_ads_types')->truncate();

        $types = [
            ['name' => 'Medium Rectangle',  'web_id' => 0, 'width' => 300, 'height' => 250, 'description' => 'This is medium rectangle ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Large Rectangle',   'web_id' => 0, 'width' => 336, 'height' => 280, 'description' => 'This is large rectangle ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Leaderboard',  'web_id' => 0, 'width' => 728, 'height' => 90, 'description' => 'This is large rectangle ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Wide Skyscraper',  'web_id' => 0, 'width' => 160, 'height' => 600, 'description' => 'This is wide skyscraper ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Half Page Ad',  'web_id' => 0, 'width' => 300, 'height' => 600, 'description' => 'This is half page ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Full Banner',  'web_id' => 0, 'width' => 970, 'height' => 90, 'description' => 'This is skyscraper ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Skyscraper',  'web_id' => 0, 'width' => 120, 'height' => 600, 'description' => 'This is large rectangle ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Banner',  'web_id' => 0, 'width' => 468, 'height' => 60, 'description' => 'This is banner ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Square',  'web_id' => 0, 'width' => 250, 'height' => 250, 'description' => 'This is square ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
            ['name' => 'Small Square',  'web_id' => 0, 'width' => 200, 'height' => 200, 'description' => 'This is small square ad type', 'title_char' => 0, 'text_char' => 0, 'status' => 1],
        ];

        foreach ($types as $type) {
            \App\Models\SiteAdsType::create($type);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Model::reguard();
    }
}
