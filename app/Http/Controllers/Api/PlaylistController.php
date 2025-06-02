<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlaylistController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('user_from_api_key')) {
            $user = $request->user_from_api_key;
            $playlists = $user->playlists()->with('tracks')->get();

            return response()->json([
                'playlists' => $playlists
            ]);
        }
    }
}
