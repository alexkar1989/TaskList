<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO: Настроить связь между role и user
        Role::upsert([
            ['role' => 'administrator', 'name' => 'Администратор'],
            ['role' => 'worker', 'name' => 'Работник'],
        ], ['role', 'name']);
    }
}
