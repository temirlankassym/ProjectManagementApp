<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Models\Document;
use App\Models\Notification;
use App\Models\Task;
use App\Models\User;
use App\Services\AwsService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private AwsService $awsService;
    private DocumentController $documentController;

    public function __construct(AwsService $awsService, DocumentController $documentController)
    {
        $this->awsService = $awsService;
        $this->documentController = $documentController;
    }

    public function addTask($id, TaskCreateRequest $request)
    {
        $data = $request->validated();
        $data['project_id'] = $id;

        Task::create($data);

        Notification::create([
            'receiver' => User::find($data['assignee_id'])->email,
            'description' => 'You have a new task!'
        ]);

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

        $document = Document::create([
            'task_id' => $task->id,
            'member_id' => auth()->id(),
            'words_count' => $request['words_count'],
            'path' => $path
        ]);

        if(auth()->user()->role == 'chief'){
            User::find($task->assignee_id)->increment('mistakes');
            $this->documentController->approve($document);
        }

        return redirect('/projects/' . $task->project_id);
    }

    public static function getAssignee($project_id)
    {
        $translators = User::where('role', 'translator')->whereHas('projects', function ($query) use ($project_id) {
            $query->where('projects.id', $project_id);
        })->get();

        return $translators;
    }
}
