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
            'admins',
            'admins_view',
            'admins_create',
            'admins_edit',
            'admin_delete',
            'drivers',
            'drivers_view',
            'drivers_create',
            'drivers_edit',
            'driver_delete',
            'passengers',
            'passengers_view',
            'passengers_create',
            'passengers_edit',
            'passengers_delete',
            'roles',
            'roles_view',
            'roles_create',
            'roles_edit',
            'roles_delete',
            'cars',
            'cars_view',
            'cars_edit',
            'places',
            'places_view',
            'places_create',
            'places_edit',
            'places_delete',
            'news',
            'news_view',
            'news_create',
            'news_edit',
            'news_delete',
            'tour',
            'tour_view',
            'tour_create',
            'tour_edit',
            'tour_delete',
            'emergencies',
            'emergencies_view',
            'emergencies_create',
            'emergencies_edit',
            'emergencies_delete',
            'activities',
            'activities_view',
            'activities_create',
            'activities_edit',
            'activities_delete',
            'transportations',
            'transportations_view',
            'settings',
            'settings_view',
            'settings_edit',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }


    }
}
