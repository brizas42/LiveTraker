<?php

namespace App\Notifications;

use App\Models\Goal;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GoalDeadlineReminder extends Notification
{
    use Queueable;

    public $goal;

    public function __construct(Goal $goal)
    {
        $this->goal = $goal;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'goal_id' => $this->goal->id,
            'title' => 'Rappel : Objectif bientôt à échéance',
            'message' => "Votre objectif '{$this->goal->title}' arrive à échéance le {$this->goal->deadline->format('d/m/Y')}. Ne lâchez rien !",
            'icon' => 'clock',
        ];
    }
}
