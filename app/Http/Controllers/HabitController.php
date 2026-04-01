<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HabitController extends Controller
{
    public function index(Request $request)
    {
        $habits = $request->user()->habits()->with(['logs' => function($q) {
            $q->where('completed_date', Carbon::today()->toDateString());
        }])->get();

        foreach($habits as $habit) {
            $habit->streak = $this->calculateStreak($habit);
            $habit->completed_today = $habit->logs->isNotEmpty() && $habit->logs->first()->completed;
        }

        return view('habits.index', compact('habits'));
    }

    public function create()
    {
        return view('habits.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_time' => 'nullable|date_format:H:i',
        ]);

        $request->user()->habits()->create($validated);

        return redirect()->route('habits.index')->with('success', 'Nouvelle habitude enregistrée !');
    }

    public function edit(Habit $habit)
    {
        if (request()->user()->id !== $habit->user_id) abort(403);
        return view('habits.edit', compact('habit'));
    }

    public function update(Request $request, Habit $habit)
    {
        if ($request->user()->id !== $habit->user_id) abort(403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'reminder_time' => 'nullable|date_format:H:i', // Format expected: HH:mm (e.g. 18:00)
        ]);

        // If reminder_time is formatted like H:i:s, it will still pass, but typically HTML input type="time" sends HH:mm

        $habit->update($validated);

        return redirect()->route('habits.index')->with('success', 'Habitude mise à jour avec succès.');
    }

    public function destroy(Habit $habit)
    {
        if (request()->user()->id !== $habit->user_id) abort(403);
        $habit->delete();
        return redirect()->route('habits.index')->with('success', 'Habitude supprimée.');
    }

    public function history(Request $request)
    {
        $logs = $request->user()->habitLogs()->with('habit')->orderBy('completed_date', 'desc')->get();
        
        // Grouper l'historique par date
        $groupedLogs = $logs->groupBy(function($log) {
            return $log->completed_date->format('Y-m-d');
        });

        // Calculer quelques statistiques bonus
        $totalCompleted = $logs->where('completed', true)->count();
        $totalHabits = $request->user()->habits()->count();

        return view('habits.history', compact('groupedLogs', 'totalCompleted', 'totalHabits'));
    }

    private function calculateStreak(Habit $habit)
    {
        $logs = $habit->logs()->where('completed', true)->orderBy('completed_date', 'desc')->get();
        if ($logs->isEmpty()) return 0;
        
        $lastLog = $logs->first();
        $expectedDate = Carbon::parse($lastLog->completed_date);
        
        // Si la dernière réussite date d'avant "hier", la série est d'office perdue
        if ($expectedDate->lt(Carbon::yesterday())) {
             return 0; 
        }

        $streak = 0;

        foreach ($logs as $log) {
            $logDate = Carbon::parse($log->completed_date);
            if ($logDate->format('Y-m-d') === $expectedDate->format('Y-m-d')) {
                $streak++;
                $expectedDate->subDay();
            } else {
                break;
            }
        }
        return $streak;
    }
}
