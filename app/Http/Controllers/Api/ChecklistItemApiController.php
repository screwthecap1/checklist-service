<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistItemApiController extends Controller
{
    public function store(Request $request, Checklist $checklist)
    {
        $this->authChecklist($checklist);

        $request->validate(['content' => 'required|string|max:255']);

        $item = $checklist->items()->create(['content' => $request->input('content')]);

        return response()->json($item, 201);
    }

    public function destroy(Checklist $checklist, ChecklistItem $item)
    {
        $this->authChecklist($checklist, $item);

        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }

    public function update(Request $request, Checklist $checklist, ChecklistItem $item)
    {
        $this->authChecklist($checklist, $item);

        if ($request->has('completed')) {
            $item->update(['completed' => $request->boolean('completed')]);
        }

        if ($request->has('content')) {
            $request->validate(['content' => 'required|string|max:255']);
            $item->update(['content' => $request->input('content')]);
        }
    }

    public function listItems(Request $request, Checklist $checklist)
    {
        $this->authChecklist($checklist);

        $query = $checklist->items();

        if ($request->has('completed')) {
            $query->where('completed', $request->boolean('completed'));
        }

        return response()->json($query->get());
    }

    protected function authChecklist(Checklist $checklist, ChecklistItem $item = null)
    {
        if ($checklist->user_id !== Auth::id() || ($item && $item->checklist_id !== $checklist->id)) {
            abort(403, 'Forbidden');
        }
    }
}
