<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'       => Str::uuid(),
            'name'     => 'Admin / Karyawan',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'level'    => 'admin'
        ]);

        User::create([
            'id'       => Str::uuid(),
            'name'     => 'Owner Toko',
            'username' => 'owner',
            'password' => Hash::make('owner'),
            'level'    => 'owner'
        ]);
    }
}
