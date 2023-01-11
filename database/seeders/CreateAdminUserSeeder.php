<?php
namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
    /**2
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'full_name' => 'Mohammed',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'user_type' => 0,
            'roles_name' => ["owner"],
            'user_status' => 1,
            'roles_id' => 1,
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);

        $settings = Setting::create([
            'public_price_per_km' => '1.1',
            'private_price_per_km' => '2.2',
            'map_key' => 'AIzaSyBSNQLhR2yEuFkYAoU_q4sXlvsd_8lOMBA'
        ]);
    }
}
