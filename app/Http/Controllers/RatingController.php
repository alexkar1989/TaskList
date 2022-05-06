<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class RatingController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $result = [];
        User::with('rating')->whereHas('roles', fn($query) => $query->where('role', 'worker'))->each(function($user, $index) use (&$result) {
            $rCount = $user->rating->count();
            $rSum = $user->rating->pluck('id')->sum();
            $result[$index] = $user->toArray();
            $result[$index]['rating'] = (int)round($rSum / $rCount);
        });
        return view('userRatings', ['users' => $result]);
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return Application|JsonResponse|RedirectResponse|Redirector
     */
    public function storeRating(Request $request, int $userId): JsonResponse|Redirector|Application|RedirectResponse
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::where('id', $userId)->whereHas('roles', fn($query) => $query->where('role', 'worker'))->first();
        if ($user->id) {
            $user->rating()->updateOrCreate(['producer' => auth()->user()->getAuthIdentifier()], ['rating' => $request->input('rating')]);
            return response()->json(null, 204);
        }
        return response()->json(null, 400);
    }
}
