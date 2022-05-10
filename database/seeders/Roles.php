<?php

namespace Database\Seeders;

use App\Models\Permission;
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
            ['role' => 'employer', 'name' => 'Постановщик'],
            ['role' => 'worker', 'name' => 'Исполнитель'],
        ], ['role', 'name']);

        Role::where('role', 'administrator')->first()->permissions()->attach(Permission::all()->pluck('id'));
        Role::where('role', 'employer')->first()->permissions()->attach(
            Permission::whereIn('permission', ['task_create', 'task_edit', 'file_attach', 'archive','task_attach'])->pluck('id'));
        Role::where('role', 'worker')->first()->permissions()->attach(
            Permission::whereIn('permission', ['task_show'])->pluck('id'));
    }
}
