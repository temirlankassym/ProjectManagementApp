<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'member_id', 'words_count', 'path'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function member()
    {
        return $this->belongsTo(User::class);
    }
}
