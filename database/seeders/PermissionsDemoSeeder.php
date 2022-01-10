<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
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
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'shelter_id' => 1,
            'password' =>  bcrypt('adminroot'), // password
            'remember_token' => Str::random(10),
        ]);

        $korisnik1 = User::create([
            'name' => 'Korisnik',
            'email' => 'korisnik@test.com',
            'shelter_id' => 1,
            'password' =>  bcrypt('korisnik'), // password
            'remember_token' => Str::random(10),
        ]);
        
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create role
        $role1 = Role::firstOrCreate(['name' => 'Administrator']);
        $role2 = Role::firstOrCreate(['name' => 'Oporavilište']);
        $role3 = Role::firstOrCreate(['name' => 'Korisnik']);

        // create permissions
        $edit = Permission::create(['name' => 'edit']);
        $delete = Permission::create(['name' => 'delete']);
        $create = Permission::create(['name' => 'create']);

        // assign existing permissions
        $role1->givePermissionTo([$edit, $delete, $create]);

        $superAdmin->assignRole($role1);
        $korisnik1->assignRole($role3);
    }
}
