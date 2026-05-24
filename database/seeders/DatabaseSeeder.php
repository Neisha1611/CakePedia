<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Wajib ditambahkan untuk enkripsi password

class DatabaseSeeder extends Seeder
{
   
    public function run(): void
    {
        
        User::create([
            'name' => 'Admin',
            'email' => 'admin@cakepedia.com',
            'password' => Hash::make('123456789'),
            'role' => 'admin',
        ]);

        
        User::create([
            'name' => 'agus',
            'email' => 'agusnih@gmail.com',
            'password' => Hash::make('00000000'),
            'role' => 'member',
        ]);
    }
}