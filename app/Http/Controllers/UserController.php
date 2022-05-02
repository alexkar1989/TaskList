<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }

    public function getTask()
    {
        $user = auth()->user();
        $myTasks = Task::where('user_id', $user->id)->get();
        return View('userspace', ['myTasks' => $myTasks->toArray()]);
    }
}
