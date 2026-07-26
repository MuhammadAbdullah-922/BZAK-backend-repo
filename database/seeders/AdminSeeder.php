<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Bzack Admin',
            'email'    => 'admin@bzack.com',
            'phone'    => '03001234567',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);
    }
}