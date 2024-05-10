<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Task;
use App\Models\User;

class StaffController extends Controller
{
    public function index()
    {
        $translators = User::where('role', 'translator')->get();
        $chiefs = User::where('role', 'chief')->get();

        $topMistakes = User::where('role', 'translator')->orderBy('mistakes', 'desc')->limit(5)->get();

        $topTranslated = [];

        foreach ($translators as $translator) {
            $tasks = Task::where('assignee_id', $translator->id)
                ->where('status','completed')->get();

            $count = 0;
            foreach ($tasks as $task){
                $count += Document::where('task_id',$task->id)->sum('words_count');
            }
            $topTranslated[$translator->email] = $count;
        }
        return view('staff.index', compact('translators', 'chiefs', 'topMistakes', 'topTranslated'));
    }
}
