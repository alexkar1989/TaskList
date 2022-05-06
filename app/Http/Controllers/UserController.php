<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @param ?int $userId
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function index(Request $request, ?int $userId = null): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (!$request->ajax()) return redirect('/');
        return response()->json(User::when(!is_null($userId), fn($query) => $query->where('id', $userId)->first(), fn($query) => $query->get()));
    }

    /**
     * @return Application|Factory|View
     */
    public function getTask(): View|Factory|Application
    {
        $user = auth()->user();
        $myTasks = Task::where('user_id', $user->id)->get();
        if ($myTasks->isNotEmpty()) {
            $myTasks = $myTasks->toArray();
            foreach ($myTasks as $index => $task)
                $myTasks[$index]['status'] = match ($task['status']) {
                    'in_work' => 'В работе',
                    'complete' => 'Завершена',
                };
        }
        return View('userspace', ['myTasks' => $myTasks]);
    }

    /**
     * @param Request $request
     * @param int $taskId
     * @return JsonResponse|Redirector|RedirectResponse|Application
     */
    public function linkTask(Request $request, int $taskId): JsonResponse|Redirector|RedirectResponse|Application
    {
        if (!$request->ajax()) return redirect('/');
        $task = Task::where('id', $taskId)->first();
        if (!is_null($task) && $task->id) {
            $task->user_id = auth()->user()->getAuthIdentifier();
            $task->status = 'in_work';
            $task->save();
            return response()->json(null, 204);
        } else return response()->json(null, 400);
    }

    /**
     * @param Request $request
     * @param int $taskId
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function completeTask(Request $request, int $taskId): JsonResponse|Redirector|Application|RedirectResponse
    {
        if (!$request->ajax()) return redirect('/');
        $task = Task::where('id', $taskId)->where('status', 'in_work')->first();
        if (!is_null($task) && $task->id) {
            $task->status = 'complete';
            $task->save();
            return response()->json(null, 204);
        } else return response()->json(null, 400);
    }

    /**
     * @param Request $request
     * @param int $taskId
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function cancelTask(Request $request, int $taskId): JsonResponse|Redirector|Application|RedirectResponse
    {
        if (!$request->ajax()) return redirect('/');
        $task = Task::where('id', $taskId)->where('status', 'in_work')->first();
        if (!is_null($task) && $task->id) {
            $task->status = 'new';
            $task->user_id = 0;
            $task->save();
            return response()->json(null, 204);
        } else return response()->json(null, 400);
    }


}
