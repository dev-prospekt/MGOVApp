<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsDemoSeeder::class);

        // DB::table('users')->insert([
        //     'name' => 'Pero',
        //     'email' => 'pero@gmail.com',
        //     'password' => Hash::make('Pero123'),
        // ]);
    }
}
