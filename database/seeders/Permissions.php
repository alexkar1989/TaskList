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
            'permission' => 'task_create',
            'name' => 'Создание задачи',
        ], [
            'permission' => 'task_edit',
            'name' => 'Редактирование задачи'
        ], [
            'permission' => 'task_remove',
            'name' => 'Удаление задачи'
        ], [
            'permission' => 'task_show',
            'name' => 'Просмотр задачи'
        ], [
            'permission' => 'file_attach',
            'name' => 'Подключение файлов'
        ], [
            'permission' => 'archive',
            'name' => 'Просмотр архива'
        ], [
            'permission' => 'task_attach',
            'name' => 'Назначение задачи'
        ]
        ], ['permission', 'name']);


    }
}
