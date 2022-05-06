<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class TasksController extends Controller
{
    /**
     * @param TaskRequest $request
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function index(TaskRequest $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        //if (!$request->ajax()) return redirect('/');
        if ($request->user->hasRole('administrator')) $tasks = Task::with('user')->get();
        else if ($request->user->hasRole('employer')) $tasks = Task::where('creator_id', $request->user->id)->with('user')->get();
        else $tasks = Task::where('user_id', 0)->where('status', 0)->get();

        if ($tasks->isNotEmpty()) {
            foreach ($tasks->toArray() as $index => $task) {

                switch ($task['status']) {
                    case 'new':
                        if ($request->user->hasRole('worker')) {
                            $tasks[$index]['action'] = "<button id='taskToWork_" . $task['id'] . "' data-taskId='" . $task['id'] . "'class='btn btn-primary btn-sm' type='button'>Взять в работу</button>";
                        } else $tasks[$index]['action'] = '';
                        $tasks[$index]['status'] = ['Новая'];
                        break;
                    case 'in_work':
                        $tasks[$index]['action'] = '';
                        if ($request->user->hasRole('administrator') || $request->user->hasRole('employer')) {
                            $tasks[$index]['status'] = ($task['user_id'] !== null && $task['user'] !== null) ? 'Исполняет: ' . $task['user']['name'] : '';

                        } else $tasks[$index]['status'] = 'В работе';
                        break;
                    case 'complete':
                        if ($request->user->hasRole('administrator') || $request->user->hasRole('employer')) {
                            $tasks[$index]['action'] = "<button id='payForWork_" . $task['id'] . "' data-taskId='" . $task['id'] . "' class='btn btn-primary btn-sm' type='button'>Оплатить</button>
                                <button id='sendStar_" . $task['user']['id'] . "' data-userId='" . $task['user']['id'] . "' class='btn btn-warning btn-sm' type='button'>Оценить</button>";
                        } else $tasks[$index]['action'] = "";
                        $tasks[$index]['status'] = 'Завершена: ' . $task['user']['name'];
                        break;
                    default:
                        $tasks[$index]['status'] = '';
                        $tasks[$index]['action'] = '';
                }


            }
        }
        $result = [
            'recordsTotal' => $tasks->count(),
            'recordsFiltered' => $tasks->count(),
            'data' => $tasks->toArray(),
        ];
        return response()->json($result);

    }

    /**
     * @param TaskRequest $request
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function store(TaskRequest $request): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (!$request->ajax()) return redirect('/');

        if ($request->user->hasPermission('task_create')) {

            $params = $request->input();
            $query = [
                'title' => $params['title'],
                'text' => $params['text'] ?? '',
                'cost' => $params['cost'] ?? 0,
                'creator_id' => $request->user->id,
                'status' => 'new',
            ];
            $task = Task::create($query);
//            if (!empty($params['files'])) {
//                dd($params);
//            }

            if ($task->id) return response()->json(null, 201);
            else return response()->json(null, 400);

        } else return response()->json(null, 403);
    }

    /**
     * @param TaskRequest $request
     * @param int $taskId
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function show(TaskRequest $request, int $taskId): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (!$request->ajax()) return redirect('/');
        return Response()->json(Task::where('id', $taskId)->with('files')->first());
    }

    /**
     * @param TaskRequest $request
     * @param int $taskId
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function update(TaskRequest $request, int $taskId): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (!$request->ajax()) return redirect('/');
        $params = $request->input();
        $task = Task::where('id', $taskId)->first();
        if ($task->id) {
            $query = [
                'title' => $params['title'],
                'text' => $params['text'],
                'cost' => $params['cost'],
            ];
            $task->update($query);
            if ($params['worker'] !== null) {
                $task->user_id = $params['worker'];
                $task->status = 'in_work';
                $task->save();
            }
            return response()->json(null, 204);
        }
        return response()->json(null, 404);
    }

    /**
     * @param TaskRequest $request
     * @param int $taskId
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function destroy(TaskRequest $request, int $taskId): JsonResponse|Redirector|Application|RedirectResponse
    {
        if (!$request->ajax()) return redirect('/');
        if ($request->user->hasPermission('task_remove')) {
            Task::where('id', $taskId)->delete();
            return response()->json(null, 204);
        } else return response()->json(null, 403);
    }

}
