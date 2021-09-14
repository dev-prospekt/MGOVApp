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

        // Super Admin
        $role1 = Role::create(['name' => 'Super-Admin']);

        // create roles and assign existing permissions
        $role2 = Role::create(['name' => 'Shelter-Admin']);
        $role2->givePermissionTo('edit animal data');
        $role2->givePermissionTo('delete animal data');
        $role2->givePermissionTo('publish animal data');
        $role2->givePermissionTo('unpublish animal data');

        // Users
        $role3 = Role::create(['name' => 'Shelter-User']);
        
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        // create demo users
        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'shelter_id' => 1

        ]);
        $user1->assignRole($role1);

        $user2 = User::factory()->create([
            'name' => 'Shelter User',
            'email' => 'shelter@test.com',
            'shelter_id' => 2
        ]);
        $user2->assignRole($role3);
    }
}
