<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeartbeatController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->updateQuietly([
                'last_seen_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'last_seen_at' => now()->toISOString(),
        ]);
    }
}
