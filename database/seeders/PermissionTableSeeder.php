<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissions = [
            'dashboard',
            'dashboard_view',
            'dashboard_create',
            'dashboard_edit',
            'dashboard_delete',
            'users',
            'users_view',
            'users_create',
            'users_edit',
            'users_delete',
        ];



        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }


    }
}
