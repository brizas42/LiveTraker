<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $goals = $user->goals()->with('milestones')->get();

        $activeGoalsCount = $goals->where('status', 'active')->count();
        $completedGoalsCount = $goals->where('status', 'completed')->count();
        
        $totalProgress = $goals->sum('progress_percentage');
        $averageProgress = $goals->count() > 0 ? round($totalProgress / $goals->count()) : 0;

        // Préparation des données pour le graphique (Chart.js) : Limité aux 10 prochains objectifs actifs
        $activeGoalsForChart = $goals->where('status', 'active')->sortBy('deadline')->take(10);
        
        $chartData = [
            'labels' => $activeGoalsForChart->pluck('title')->toArray(),
            'progress' => $activeGoalsForChart->pluck('progress_percentage')->toArray(),
        ];

        return view('dashboard', compact(
            'activeGoalsCount',
            'completedGoalsCount',
            'averageProgress',
            'chartData',
            'goals'
        ));
    }
}
