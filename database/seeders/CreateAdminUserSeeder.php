<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'is_super' => 1,
        ]);
        $role = Role::create(['name' => 'Admin','guard_name' => 'admin']);

        $permissions = Permission::pluck('id','id')->all();
        
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
