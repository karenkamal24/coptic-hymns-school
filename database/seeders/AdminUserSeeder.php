<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@coptichymns.com'],
            [
                'name' => 'Super Admin',
                'phone_number' => '01000000000',
                'address' => 'Cairo',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
