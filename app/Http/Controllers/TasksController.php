<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function index(TaskRequest $request): JsonResponse
    {
        if ($request->user->hasRole('administrator')) {
            $tasks = Task::with('user')->get();
        } else if ($request->user->hasRole('employer')) {
            $tasks = Task::where('creator_id', $request->user->id)->with('user')->get();
        } else {
            $tasks = Task::where('user_id', 0)->where('status', 0)->get();
        }
        if ($tasks->isNotEmpty()) {
            foreach ($tasks->toArray() as $index => $task) {

                if ($request->user->hasRole('administrator') || $request->user->hasRole('employer')) {
                    $tasks[$index]['status'] = ($task['user_id'] !== null && $task['user'] !== null) ? 'Исполняет: ' . $task['user']['name'] : '';
                } else $tasks[$index]['status'] = "<button id='taskToWork_" . $task['id'] . "' class='btn btn-primary btn-sm' type='button'>Взять в работу</button>";

            }
        }
        return response()->json($tasks);

    }

    /**
     * @param TaskRequest $request
     * @return JsonResponse
     */
    public function store(TaskRequest $request): JsonResponse
    {
        if ($request->user->hasPermission('task_create')) {

            $params = $request->input();
            $query = [
                'title' => $params['title'],
                'text' => $params['text'],
                'cost' => $params['cost'],
                'creator_id' => $request->user->id,
            ];
            $task = Task::create($query);
            if (!empty($params['files'])) {
                dd($params);
            }

            if ($task->id) return response()->json(null, 201);
            else return response()->json(null, 400);

        } else return response()->json(null, 403);
    }

    /**
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(TaskRequest $request, int $id): JsonResponse
    {
        return Response()->json(Task::where('id', $id)->with('files')->first());
    }

    /**
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskRequest $request, int $id): JsonResponse
    {
        $params = $request->input();
        $task = Task::where('id', $id)->first();
        if ($task->id) {
            $query = [
                'title' => $params['title'],
                'text' => $params['text'],
                'cost' => $params['cost'],
            ];
            if ($params['worker'] !== null) {
                $query['user_id'] = $params['worker'];
            }
            $task->update($query);
            return response()->json(null, 204);
        }
        return response()->json(null, 404);
    }

    /**
     * @param TaskRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(TaskRequest $request, int $id): JsonResponse
    {
        if ($request->user->hasPermission('task_remove')) {
            Task::where('id', $id)->delete();
            return response()->json(null, 204);
        } else return response()->json(null, 403);
    }
}
