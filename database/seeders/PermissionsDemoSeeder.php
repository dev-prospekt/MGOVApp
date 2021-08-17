<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit animal data']);
        Permission::create(['name' => 'delete animal data']);
        Permission::create(['name' => 'publish animal data']);
        Permission::create(['name' => 'unpublish animal data']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Shelter-Admin']);
        $role1->givePermissionTo('edit animal data');
        $role1->givePermissionTo('delete animal data');
        $role1->givePermissionTo('publish animal data');
        $role1->givePermissionTo('unpublish animal data');


        $role2 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = User::factory()->create([
            'name' => 'Shelter User',
            'email' => 'shelter@test.com',
        ]);
        $user->assignRole($role1);

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
        ]);
        $user->assignRole($role2);
    }
}
