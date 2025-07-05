<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistController extends Controller
{
    public function index()
    {
        $checklists = Checklist::where('user_id', Auth::id())->get();
        return view('checklists.index', compact('checklists'));
    }

    public function create()
    {
        return view('checklists.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->checklists()->count() >= $user->checkListLimit()) {
            return redirect()->route('checklists.index')->with('error', 'You heave reached the limit!');
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        Checklist::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);

        return redirect()->route('checklists.index')->with('succes', 'Check-list created!');
    }

    public function show(Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            abort(403);
        }

        $checklist->load('items');

        return view('checklists.show', compact('checklist'));
    }

    public function edit(Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checklists.edit', compact('checklist'));
    }

    public function update(Request $request, Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $checklist->update([
            'title' => $request->title,
        ]);

        return redirect()->route('checklists.index')->with('succes', 'Check-list updated!');
    }

    public function destroy(Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            abort(403);
        }

        $checklist->delete();

        return redirect()->route('checklists.index')->with('success', 'Check-list deleted!');
    }
}
