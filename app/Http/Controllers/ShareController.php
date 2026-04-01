<?php

namespace App\Http\Controllers;

use App\Models\Goal;

class ShareController extends Controller
{
    public function show(Goal $goal)
    {
        // On permet de voir l'objectif partagé sans être authentifié.
        // Optionnellement, on pourrait vérifier si c'est public.
        
        $goal->load('milestones');
        
        return view('share.show', compact('goal'));
    }
}
