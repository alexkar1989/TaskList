<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin Example',
            'email' => 'admin@example.ru',
            'password' => Hash::make('12345678')
        ]);
        $user->roles()->attach(1);

        $user = User::create([
            'name' => 'Постановщик',
            'email' => 'employer@example.ru',
            'password' => Hash::make('12345678')
        ]);
        $user->roles()->attach(2);
    }
}
