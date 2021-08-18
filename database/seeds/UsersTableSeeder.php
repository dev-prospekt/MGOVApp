<?php
namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
        ]);
    }
}