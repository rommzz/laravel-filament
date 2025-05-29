<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
