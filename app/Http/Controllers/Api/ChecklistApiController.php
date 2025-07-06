<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistApiController extends Controller
{
    public function index()
    {
        $checklists = Auth::user()->checklists()->get();
        return response()->json($checklists);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->checklists()->count() >= $user->checkListLimit()) {
            return response()->json(['message' => 'Checklist limit reached'], 403);
        }

        $request->validate(['title' => 'required|string|max:255']);

        $checklist = $user->checklists()->create(['title' => $request->title]);

        return response()->json($checklist, 201);
    }

    public function destroy(Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $checklist->delete();

        return response()->json(['message' => 'Checklist deleted']);
    }
}
