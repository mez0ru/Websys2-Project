<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidatesAppliedController extends Controller
{
    public function show($id)
    {
        $job = JobPost::with('applied.candidate')
        ->find($id);

        $this->authorize('view', $job);

        $title = $job->title;
        $applications = $job->applied()->paginate(5);
        $count = $job->applied->count();
        return view('hirer.candidatesAppliedList', compact('title', 'count', 'applications'));
    }
}
