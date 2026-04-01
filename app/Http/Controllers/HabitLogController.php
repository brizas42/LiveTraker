<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HabitLogController extends Controller
{
    /**
     * Valide (ou invalide) une habitude pour la journée en cours.
     */
    public function toggle(Request $request, Habit $habit)
    {
        if ($request->user()->id !== $habit->user_id) abort(403);

        $today = Carbon::today()->toDateString();
        
        $log = $habit->logs()->where('completed_date', $today)->first();

        if ($log) {
            // S'il existe, l'utilisateur souhaite annuler sa réalisation du jour
            $log->delete();
            $message = 'Habitude annulée pour aujourd\'hui.';
        } else {
            // Sinon on l'enregistre comme terminée aujourd'hui
            $habit->logs()->create([
                'user_id' => $request->user()->id,
                'completed_date' => $today,
                'completed' => true,
            ]);
            $message = 'Excellent travail ! Habitude réussie pour aujourd\'hui 🔥';
        }

        return back()->with('success', $message);
    }
}
