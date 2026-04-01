<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGoalRequest;
use App\Http\Requests\UpdateGoalRequest;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $goals = $request->user()->goals()
            ->withCount('milestones')
            ->orderBy('status', 'asc')
            ->orderBy('deadline', 'asc')
            ->get();
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(StoreGoalRequest $request)
    {
        $data = $request->validated();
        $milestones = $data['milestones'] ?? [];

        // Retirer les milestones des données pour ne pas interferer avec le modèle
        unset($data['milestones']); 
        
        $goal = $request->user()->goals()->create($data);

        // Ajouter les étapes initiales saisies lors de la création
        foreach ($milestones as $mTitle) {
            if (trim($mTitle) !== '') {
                $goal->milestones()->create(['title' => trim($mTitle)]);
            }
        }

        // Mettre à jour la progression initiale (% et statuts)
        $goal->recalculateProgress(null, $request->user()->id);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Objectif créé avec succès !');
    }

    public function show(Goal $goal)
    {
        // En Laravel 11/12 on autorise via Controller Helper ou Policy direct
        if (request()->user()->cannot('view', $goal)) {
            abort(403);
        }

        $goal->load(['milestones', 'progressLogs' => function($q) {
            $q->latest()->take(10);
        }]);

        return view('goals.show', compact('goal'));
    }

    public function edit(Goal $goal)
    {
        if (request()->user()->cannot('update', $goal)) {
            abort(403);
        }

        return view('goals.edit', compact('goal'));
    }

    public function update(UpdateGoalRequest $request, Goal $goal)
    {
        if ($request->user()->cannot('update', $goal)) {
            abort(403);
        }

        $data = $request->validated();
        unset($data['milestones']);

        $goal->update($data);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Objectif mis à jour.');
    }

    public function destroy(Goal $goal)
    {
        if (request()->user()->cannot('delete', $goal)) {
            abort(403);
        }

        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Objectif supprimé.');
    }
}
