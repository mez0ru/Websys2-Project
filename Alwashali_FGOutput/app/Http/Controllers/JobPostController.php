<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = JobPost::with('requirement')
        ->orderBy('id', 'DESC')->Paginate(2);
        $count = $jobs->total();
        return view('hirer.dashboard', compact('jobs', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title'                          => 'required|max:255',
        //     'job_description'                => 'required',
        //     'salary_from'                    => 'required',
        //     'salary_to'                      => 'required',
        //     'apply_until'                    => 'required',
        //     'social_media_accounts'          => 'required',
        //     'gender'                         => 'required',
        //     'age'                            => 'required',
        //     'min_work_experience'            => 'required',
        //     'min_work_experience_range_type' => 'required',
        //     'qualifications'                 => 'required',
        // ]);

        $reqs = Requirement::updateOrCreate(['id' => $request->reqid], [
            'gender' => $request->gender,
            'age' => $request->age,
            'country' => 'Philippines',
            'qualifications' => $request->qualifications,
            'min_work_experience' => $request->min_work_experience,
            'min_work_experience_range_type' => $request->min_work_experience_range_type,
        ]);

        $post = JobPost::updateOrCreate(['id' => $request->id], [
            'title' => $request->title,
            'job_description' => $request->job_description,
            'salary_from' => $request->salary_from,
            'salary_to' => $request->salary_to,
            'requirement_id' => $reqs->id,
            'apply_until' => $request->apply_until,
            'social_media_accounts' => $request->social_media_accounts,
        ]);
        
        $jobs = JobPost::with('requirement')
        ->orderBy('id', 'DESC')->Paginate(2, ['*'], 'page', $request->active_page);

        $returnedHTML = view('components.job-post')->with('jobs', $jobs)->render();
        return response()->json(['code' => 200, 'html' => $returnedHTML, 'count' => $jobs->total()], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function show(JobPost $jobPost)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    // public function edit(JobPost $jobPost)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobPost $jobPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobPost  $jobPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = JobPost::find($id)->delete();
        return route('jobs.index', ['delete' => 'Job posting have been removed successfully']);
        // response()->json(['success'=>'Post Deleted successfully']);
    }
}
