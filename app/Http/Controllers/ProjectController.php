<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Models\Document;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class ProjectController extends Controller
{
    public function index()
    {
        $translators = User::where('role','translator')->get();
        if(auth()->user()->role == 'manager')
            $projects = Project::all();
        else{
            $projects = auth()->user()->projects;
        }

        foreach ($projects as $project) {
            $documents = Document::whereHas('task', function ($query) use ($project) {
                $query->where('status', 'completed')->where('project_id', $project->id);
            })->get();

            $count = 0;
            foreach ($documents as $document) {
                $count += $document->words_count;
            }

            $project['count'] = $count;
        }

        $totalWords = 0;
        $translatedWords = 0;

        foreach ($projects as $project) {
            $totalWords += $project->words_count;
            $translatedWords += $project->count;
        }

        $wordsLeft = $totalWords - $translatedWords;


        return view('home', ['projects' => $projects,'translators'=>$translators,'totalWords' => $totalWords, 'translatedWords' => $translatedWords, 'wordsLeft' => $wordsLeft]);
    }

    public function show($id)
    {
        $project = Project::find($id);
        $translators = User::where('role','translator')->get();
        $tasks = Task::where('project_id', $id)->get();
        $chiefs = User::where('role','chief')->get();

        $documents = Document::whereHas('task', function ($query) {
            $query->where('status', 'completed');
        })->get();

        $count = 0;
        foreach ($documents as $document) {
            $count += $document->words_count;
        }

        return view('project', ['project' => $project, 'translators' => $translators, 'chiefs'=>$chiefs, 'tasks' => $tasks, 'count' => $count]);
    }

    public function create(ProjectCreateRequest $request)
    {
        $data = $request->validated();
        $data['project_manager'] = auth()->user()->email;

        $project = Project::create($data);

        return redirect('/home');
    }

    public function addMember($id, Request $request)
    {
        if (ProjectMember::where('project_id', $id)->where('member_id', $request['member'])->exists()) {
            return redirect("/projects/$id");
        }
        ProjectMember::create([
            'project_id' => $id,
            'member_id' => $request['member']
        ]);

        return redirect("/projects/$id");
    }

    public function removeMember($id, Request $request)
    {
        ProjectMember::where('project_id', $id)->where('member_id', $request['member'])->delete();

        return redirect("/projects/$id");
    }
}
