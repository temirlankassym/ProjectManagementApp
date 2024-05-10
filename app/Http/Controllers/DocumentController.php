<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DocumentController extends Controller
{
    public function approve(Document $document)
    {
        $document->task->update(['status' => 'completed']);

        Document::where('task_id', $document->task_id)->where('id', '!=', $document->id)->delete();

        $project = $document->task->project;

        $documents = Document::whereHas('task', function ($query) use ($project) {
            $query->where('status', 'completed')->where('project_id', $project->id);
        })->get();

        $count = 0;
        foreach ($documents as $doc) {
            $count += $doc->words_count;
        }

        if ($count >= $project->words_count) {
            $project->status = 'completed';
            $project->save();
            return redirect('/home')->with('status', 'Project deleted successfully due to exceeding word count.');
        }

        return redirect('/projects/' . $document->task->project_id);
    }

    public function disapprove(Document $document)
    {
        $projectId = $document->task->project_id;
        $document->delete();
        return redirect('/projects/' . $projectId);
    }
}
