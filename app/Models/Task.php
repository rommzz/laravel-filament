<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'project_id', 'user_id', 'due_date', 'status'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusString(): string
    {
        // 0: todo, 1: in progress, 2: done
        return match ($this->status) {
            0 => 'Todo',
            1 => 'In Progress',
            2 => 'Done',
        };
    }

    public function completePercentage()
    {
        $totalSubtasks = $this->subtasks()->count();
        if ($totalSubtasks === 0) {
            return 0;
        }

        $completedSubtasks = $this->subtasks()->where('completed', true)->count();
        return ($completedSubtasks / $totalSubtasks) * 100;
    }
}
