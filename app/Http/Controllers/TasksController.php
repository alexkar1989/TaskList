<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = Task::get();
        return response()->json($tasks);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $params = $request->input();
        $id = Task::create([
            'title' => $params['title'],
            'text' => $params['text'],
            'cost' => $params['cost'],
        ])?->id;
        if($id) return response()->json(null, 201);
        else return response()->json(null, 400);

    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return Response()->json(Task::where('id', $id)->with('files')->first());
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $params = $request->input();
        Task::where('id', $id)->update([
            'title' => $params['text'],
            'text' => $params['text'],
            'cost' => $params['cost'],
        ]);
        return response()->json(null, 204);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        Task::where('id', $id)->delete();
        return response()->json(null, 204);
    }
}
