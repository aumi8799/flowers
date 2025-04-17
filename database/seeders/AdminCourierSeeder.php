<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminCourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administratorius',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    
        // Kurjeris
        User::create([
            'name' => 'Kurjeris Jonas',
            'email' => 'courier@example.com',
            'password' => Hash::make('courier123'),
            'role' => 'courier',
        ]);
    }
}
