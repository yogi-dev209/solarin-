<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ---------------------------------------------------
        // 1. Akun Admin Utama
        // ---------------------------------------------------
        User::create([
            'name' => 'Admin Solarin',
            'username' => 'admin',
            'email' => 'admin@solarin.test',
            'phone' => '081234567890',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'aktif',
            'theme' => 'light',
            'join_date' => Carbon::now()->subMonths(12),
        ]);

        // ---------------------------------------------------
        // 2. Akun Sopir 1 (Parto - Sesuai UI Profil)
        // ---------------------------------------------------
        User::create([
            'name' => 'Parto',
            'username' => 'parto',
            'email' => 'parto@gmail.com',
            'phone' => '085143785421',
            'password' => Hash::make('password'),
            'role' => 'sopir',
            'status' => 'aktif',
            'theme' => 'light',
            'address' => 'Sidoarjo',
            'operational_area' => 'Sidoarjo',
            'join_date' => Carbon::now()->subMonths(6),
        ]);

        // ---------------------------------------------------
        // 3. Akun Sopir 2 (Sopir Demo)
        // ---------------------------------------------------
        User::create([
            'name' => 'Sopir Demo',
            'username' => 'sopir',
            'email' => 'sopir@solarin.test',
            'phone' => '081233445566',
            'password' => Hash::make('password'),
            'role' => 'sopir',
            'status' => 'aktif',
            'theme' => 'light',
            'address' => 'Surabaya',
            'operational_area' => 'Surabaya',
            'join_date' => Carbon::now()->subMonths(5),
        ]);

        // ---------------------------------------------------
        // 4. Akun Sopir 3
        // ---------------------------------------------------
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budisantoso',
            'email' => 'budi@solarin.test',
            'phone' => '082233445566',
            'password' => Hash::make('password'),
            'role' => 'sopir',
            'status' => 'aktif',
            'theme' => 'light',
            'address' => 'Gresik',
            'operational_area' => 'Gresik',
            'join_date' => Carbon::now()->subMonths(4),
        ]);

        // ---------------------------------------------------
        // 5. Akun Sopir 4
        // ---------------------------------------------------
        User::create([
            'name' => 'Joko Widodo',
            'username' => 'jokowidodo',
            'email' => 'joko@solarin.test',
            'phone' => '083344556677',
            'password' => Hash::make('password'),
            'role' => 'sopir',
            'status' => 'aktif',
            'theme' => 'light',
            'address' => 'Mojokerto',
            'operational_area' => 'Mojokerto',
            'join_date' => Carbon::now()->subMonths(3),
        ]);

        // ---------------------------------------------------
        // 6. Akun Sopir 5
        // ---------------------------------------------------
        User::create([
            'name' => 'Anton Syahputra',
            'username' => 'anton',
            'email' => 'anton@solarin.test',
            'phone' => '084455667788',
            'password' => Hash::make('password'),
            'role' => 'sopir',
            'status' => 'aktif',
            'theme' => 'light',
            'address' => 'Pasuruan',
            'operational_area' => 'Pasuruan',
            'join_date' => Carbon::now()->subMonths(2),
        ]);
    }
}