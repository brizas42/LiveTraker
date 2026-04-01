<?php

namespace App\Notifications;

use App\Models\Goal;
use App\Models\Milestone;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MilestoneCompleted extends Notification
{
    use Queueable;

    public $goal;
    public $milestone;

    public function __construct(Goal $goal, Milestone $milestone)
    {
        $this->goal = $goal;
        $this->milestone = $milestone;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'goal_id' => $this->goal->id,
            'title' => 'Étape validée !',
            'message' => "Félicitations, vous avez validé l'étape '{$this->milestone->title}' de l'objectif '{$this->goal->title}'.",
            'icon' => 'check-circle',
        ];
    }
}
