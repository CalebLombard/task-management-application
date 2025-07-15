<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description', 
        'priority',
        'status',
        'assigned_to',
        'category',
        'deadline'
    ];

    protected $casts = [
        'deadline' => 'datetime',
        'priority' => 'string',
        'status' => 'string',
    ];

    protected $dates = [
        'deadline',
    ];

    /**
     * Get the user assigned to the task
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Scope for overdue tasks
     */
    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
                    ->where('status', '!=', 'completed');
    }

    /**
     * Accessor for formatted deadline
     */
    public function getFormattedDeadlineAttribute(): ?string
    {
        return $this->deadline?->format('M j, Y g:i A');
    }

    /**
     * Mutator for deadline
     */
    public function setDeadlineAttribute($value): void
    {
        $this->attributes['deadline'] = $value ?: null;
    }
}