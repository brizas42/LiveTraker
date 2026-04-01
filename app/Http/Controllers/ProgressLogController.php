<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgressRequest;
use App\Models\Goal;
use Illuminate\Http\Request;

class ProgressLogController extends Controller
{
    public function store(StoreProgressRequest $request, Goal $goal)
    {
        if ($request->user()->cannot('update', $goal)) {
            abort(403);
        }

        $data = $request->validated();
        
        // Créer le log de progression
        $goal->progressLogs()->create([
            'user_id' => $request->user()->id,
            'progress_value' => $data['progress_value'],
            'note' => $data['note'] ?? null,
        ]);

        // Mettre à jour l'objectif
        $goal->update([
            'progress_percentage' => $data['progress_value'],
            'status' => $data['progress_value'] >= 100 ? 'completed' : 'active',
        ]);

        // Si l'objectif est atteint, on pourrait déclencher un événement ou une notification ici

        return back()->with('success', 'Progression enregistrée.');
    }
}
