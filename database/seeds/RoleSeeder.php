<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('roles')->truncate();

        $roles = ['admin', 'client', 'employee', 'developer'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Model::reguard();
    }
}
