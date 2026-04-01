<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Habit;

class HabitReminder extends Notification
{
    use Queueable;

    public $habit;

    public function __construct(Habit $habit)
    {
        $this->habit = $habit;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon' => '🔥',
            'title' => 'Rappel : ' . $this->habit->name,
            'message' => 'Il est l\'heure de passer à l\'action ! N\'oubliez pas de valider votre habitude.',
            'url' => route('habits.index'),
            'type' => 'habit_reminder',
            'habit_id' => $this->habit->id,
        ];
    }
}
