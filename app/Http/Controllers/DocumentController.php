<?php

namespace App\Http\Controllers;

use App\Models\Document;

class DocumentController extends Controller
{
    public function approve(Document $document)
    {
        $document->task->update(['status' => 'completed']);

        Document::where('task_id', $document->task_id)->where('id', '!=', $document->id)->delete();

        return redirect('/projects/' . $document->task->project_id);
    }

    public function disapprove(Document $document)
    {
        $projectId = $document->task->project_id;
        $document->delete();
        return redirect('/projects/' . $projectId);
    }
}
