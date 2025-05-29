<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $fillable = ['title', 'completed', 'task_id'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }
}
