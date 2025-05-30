<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(): JsonResponse{
        
        $notes = Note::all();
        
        if ($notes->isEmpty()) {
            return response()->json([
                'message' => 'No notes found',
                'data' => []
            ], status: 404);
        }

        return response()->json($notes);
    }
}
