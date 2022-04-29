<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //TODO: Настроить связь между role и permission
        Permission::upsert([[
            'permission' => 'create_task',
            'name' => 'Создание задачи',
        ], [
            'permission' => 'delete_task',
            'name' => 'Удаление задачи'
        ], [
            'permission' => 'attache_file',
            'name' => 'Подключение файлов'
        ], [
            'permission' => 'List_archive',
            'name' => 'Просмотр архива'
        ]
        ], ['permission', 'name']);
    }
}
