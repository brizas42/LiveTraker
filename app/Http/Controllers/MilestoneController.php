<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMilestoneRequest;
use App\Models\Goal;
use App\Models\Milestone;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    public function store(StoreMilestoneRequest $request, Goal $goal)
    {
        if ($request->user()->cannot('update', $goal)) {
            abort(403);
        }

        $goal->milestones()->create($request->validated());
        $goal->recalculateProgress(null, $request->user()->id);

        return back()->with('success', 'Étape ajoutée avec succès.');
    }

    public function update(Request $request, Goal $goal, Milestone $milestone)
    {
        if ($request->user()->cannot('update', $goal) || $milestone->goal_id !== $goal->id) {
            abort(403);
        }

        $completed = $request->boolean('completed');
        $note = null;

        // Si l'étape vient d'être cochée (false -> true), on capture la note éventuelle
        if ($completed && !$milestone->completed) {
            $note = $request->input('note');
        }

        $milestone->update([
            'completed' => $completed,
            'completed_at' => $completed ? now() : null,
        ]);

        $goal->recalculateProgress($note, $request->user()->id);

        return back()->with('success', 'Étape mise à jour.');
    }

    public function destroy(Request $request, Goal $goal, Milestone $milestone)
    {
        if ($request->user()->cannot('update', $goal) || $milestone->goal_id !== $goal->id) {
            abort(403);
        }

        $milestone->delete();
        $goal->recalculateProgress(null, $request->user()->id);

        return back()->with('success', 'Étape supprimée.');
    }
}
