<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class MainController extends Controller
{
    public function index()
    {
        return View('main');
    }

    /**
     * @param Request $request
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function getUserRole(Request $request): JsonResponse|Redirector|Application|RedirectResponse
    {
        if (!$request->ajax()) return redirect('/');
        $user = auth()->user();
        $roles = User::where('id', $user->id)->with('roles')->first()?->roles->pluck('role');
        if (!empty($roles)) return response()->json($roles);
        else return response()->json(null, 204);
    }

    /**
     * @param int $taskId
     * @param int $fileId
     * @return Application|ResponseFactory|Response
     */
    public function downloadFile(int $taskId, int $fileId): Response|Application|ResponseFactory
    {
        $file = Task::where('id', $taskId)->with('files', fn($query) => $query->where('id', $fileId))->first()?->files->first();
        return response(base64_decode($file->file))->withHeaders([
            'Content-Type' => $file->type,
            'Content-Disposition' => 'attachment; filename="' . $file->name . '"',
            'Content-Length' => $file->size,
        ]);
    }
}
