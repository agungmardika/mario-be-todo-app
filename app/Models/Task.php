<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'progress', 'parent_id', 'todo_id', 'user_id', 'status'];

    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function todo()
    {
        return $this->belongsTo(Todo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
