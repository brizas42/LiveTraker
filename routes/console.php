<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Goal;
use App\Notifications\GoalDeadlineReminder;
use App\Models\Habit;
use App\Notifications\HabitReminder;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $goals = Goal::where('status', 'active')
        ->where('deadline', '=', now()->addDay()->toDateString())
        ->get();

    foreach ($goals as $goal) {
        $goal->user->notify(new GoalDeadlineReminder($goal));
    }
})->dailyAt('09:00')->description('Envoi de rappels de deadline pour les objectifs (J-1)');

Schedule::call(function () {
    $now = now()->format('H:i');
    
    // Find all habits that have a reminder exactly for the current minute
    $habits = Habit::whereRaw("DATE_FORMAT(reminder_time, '%H:%i') = ?", [$now])->with('user')->get();

    foreach ($habits as $habit) {
        $doneToday = $habit->logs()->where('completed_date', now()->toDateString())->exists();
        if (!$doneToday) {
            $habit->user->notify(new HabitReminder($habit));
        }
    }
})->everyMinute()->description('Envoi de rappels pour les habitudes');
