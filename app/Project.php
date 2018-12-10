<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Task;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)
            ->orderBy('created_at', 'desc');
    }
}