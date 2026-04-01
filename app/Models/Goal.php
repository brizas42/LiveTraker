<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'start_date',
        'deadline',
        'status',
        'progress_percentage',
        'specific',
        'measurable',
        'achievable',
        'relevant',
        'time_bound',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        'progress_percentage' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class);
    }

    public function progressLogs(): HasMany
    {
        return $this->hasMany(ProgressLog::class);
    }

    /**
     * Calcule automatiquement la progression selon les étapes
     * et enregistre optionnellement un log de progression avec note.
     */
    public function recalculateProgress(?string $note = null, ?int $userId = null): int
    {
        $total = $this->milestones()->count();
        $completedCount = $this->milestones()->where('completed', true)->count();

        $percentage = $total > 0 ? (int) round(($completedCount / $total) * 100) : 0;
        $status = $percentage >= 100 ? 'completed' : 'active';

        // Ne pas écraser 'failed' si l'objectif était échoué manuellement, sauf si on revote ?
        // Simplifions: on remplace le statut
        $this->update([
            'progress_percentage' => $percentage,
            'status' => $status,
        ]);

        // Si une note est fournie, on l'ajoute au journal accompagné de sa nouvelle progression
        if ($note !== null) {
            $this->progressLogs()->create([
                'user_id' => $userId ?? $this->user_id,
                'progress_value' => $percentage,
                'note' => $note,
            ]);
        }

        return $percentage;
    }
}
