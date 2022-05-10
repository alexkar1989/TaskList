<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;

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

    public function downloadFile($taskId, $fileId)
    {
        $file = Task::where('id', $taskId)->with('files', fn($query) => $query->where('id', $fileId))->first()?->files->first();
        if (Storage::put($file->name, base64_decode($file->file))) {
            return Storage::download($file->name);
        }
    }
}
