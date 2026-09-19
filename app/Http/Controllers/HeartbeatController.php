<?php

namespace App\Http\Controllers;

use App\Events\UserPresenceUpdated;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeartbeatController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
            ], 401);
        }

        $now = now();

        $user->updateQuietly([
            'last_seen_at' => $now,
        ]);

        $online = User::query()
            ->whereNotNull('last_seen_at')
            ->where('last_seen_at', '>=', $now->copy()->subSeconds(30))
            ->count();

        broadcast(new UserPresenceUpdated($online));

        return response()->json([
            'success' => true,
            'online' => $online,
            'last_seen_at' => $now->toISOString(),
        ]);
    }
}
