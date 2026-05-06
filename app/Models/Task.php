<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'priority',
        'status',
        'project_id',
        'assigned_to',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relationships
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Accessor: human-readable status label (used in views + TaskResource)
     * status values: todo | in_progress | done
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'todo' => 'To Do',
            'in_progress' => 'In Progress',
            'done' => 'Completed',
            default => ucfirst(str_replace('_', ' ', (string) $this->status)),
        };
    }

    /**
     * Accessor: urgency indicator based on deadline (used in task list US8)
     * returns: "Urgent" | "Soon" | "On Track"
     */
    public function getDeadlineStatusAttribute(): string
    {
        if (!$this->deadline) {
            return 'On Track';
        }

        $today = Carbon::today();
        $deadline = $this->deadline instanceof Carbon
            ? $this->deadline->startOfDay()
            : Carbon::parse($this->deadline)->startOfDay();

        $daysLeft = $today->diffInDays($deadline, false); // negative if overdue

        // If already done, not urgent
        if ($this->status === 'done') {
            return 'On Track';
        }

        // Urgent: within 48 hours (<= 2 days from today, including today)
        if ($daysLeft <= 2 && $daysLeft >= 0) {
            return 'Urgent';
        }

        // Overdue
        if ($daysLeft < 0) {
            return 'Urgent';
        }

        // Soon-ish (optional, adjust if you want)
        if ($daysLeft <= 5) {
            return 'Soon';
        }

        return 'On Track';
    }

    /**
     * Local scope: urgent() — tasks whose deadline is within 48 hours and whose status is not done (bonus)
     */
    public function scopeUrgent(Builder $query): Builder
    {
        $now = Carbon::now();
        $in48h = Carbon::now()->addHours(48);

        return $query
            ->where('status', '!=', 'done')
            ->whereBetween('deadline', [$now->toDateString(), $in48h->toDateString()]);
    }
}