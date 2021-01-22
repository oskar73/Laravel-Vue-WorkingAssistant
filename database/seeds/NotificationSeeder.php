<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
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

        DB::table('notification_categories')->truncate();
        $path = __DIR__.'/source/notification_categories.sql';
        DB::unprepared(file_get_contents($path));

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Model::reguard();

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('notification_templates')->truncate();
        $path = __DIR__.'/source/notification_templates.sql';
        DB::unprepared(file_get_contents($path));

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        Model::reguard();
    }
}
