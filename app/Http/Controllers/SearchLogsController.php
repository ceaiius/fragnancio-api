<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchLogsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        SearchLogs::create([
            'query' => $request->input('query'),
            'user_id' => Auth::check() ? Auth::id() : null,
        ]);

        return response()->json(['message' => 'Search logged successfully.']);
    }

    public function get()
    {
        $trending = SearchLogs::select('query', DB::raw('count(*) as count'))
            ->groupBy('query')
            ->orderByDesc('count')
            ->limit(5)
            ->pluck('query');

        return response()->json(['trending' => $trending]);
    }
}
