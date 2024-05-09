<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'words_count',
        'due_date',
        'project_manager',
    ];

    public function manager(){
        return $this->belongsTo(User::class, 'project_manager', 'email');
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members', 'project_id', 'member_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
