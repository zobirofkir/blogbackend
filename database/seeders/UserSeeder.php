<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        User::create([
            "name" => "zobir",
            "email" => "zobirofkir19@gmail.com",
            "password" => Hash::make("password123"),
            "role_id" => $adminRole->id
        ]);
    }
}
