<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                'name' => 'Super User',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('verysafepassword'),
                'approved_at' => now(),
                'role_id' => 4,
        ]);
    }
}
