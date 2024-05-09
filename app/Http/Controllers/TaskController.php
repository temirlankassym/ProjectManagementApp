<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Models\Document;
use App\Models\Task;
use App\Services\AwsService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private AwsService $awsService;

    public function __construct(AwsService $awsService)
    {
        $this->awsService = $awsService;
    }

    public function addTask($id, TaskCreateRequest $request)
    {
        $data = $request->validated();
        $data['project_id'] = $id;
        Task::create($data);
        return redirect('/projects/' . $request['project_id']);
    }

    public function removeTask($id, Task $task)
    {
        $task->delete();
        return redirect('/projects/' . $id);
    }

    public function submit(Task $task,Request $request)
    {
        $path = $this->awsService->store($request['file']);

        Document::create([
            'task_id' => $task->id,
            'member_id' => auth()->id(),
            'words_count' => $request['words_count'],
            'path' => $path
        ]);

        return redirect('/projects/' . $task->project_id);
    }
}
