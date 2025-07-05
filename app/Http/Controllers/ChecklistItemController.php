<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistItemController extends Controller
{
    public function store(Request $request, Checklist $checklist)
    {
        if ($checklist->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $checklist->items()->create([
            'content' => $request->input('content'),
        ]);

        return redirect()->route('checklists.show', $checklist);
    }

    public function update(Request $request, Checklist $checklist, ChecklistItem $item)
    {
        if ($checklist->user_id !== Auth::id() || $item->checklist_id !== $checklist->id) {
            abort(403);
        }

        if ($request->has('completed') && !$request->has('content')) {
            $item->update(['completed' => $request->boolean('completed')]);
            return redirect()->route('checklists.show', $checklist);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $item->update(['content' => $request->input('content')]);

        return redirect()->route('checklists.show', $checklist)->with('success', 'Пункт обновлён!');
    }


    public function destroy(Checklist $checklist, ChecklistItem $item)
    {
        if ($checklist->user_id !== Auth::id() || $item->checklist_id !== $checklist->id) {
            abort(403);
        }

        $item->delete();

        return redirect()->route('checklists.show', $checklist);
    }
}
