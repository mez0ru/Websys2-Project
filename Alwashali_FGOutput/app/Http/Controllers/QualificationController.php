<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Qualification;
use Illuminate\Support\Facades\Auth;

class QualificationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Qualification::class, 'qualification');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qualifications = Qualification::where('candidate_id', Auth::user()->id)->orderBy('id', 'DESC')->Paginate(5);
        $count = $qualifications->total();
        return view('candidate.qualifications', compact('qualifications', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidate.add-qualification');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Qualification::create($request->merge(['candidate_id' => Auth::user()->id])->all());
        return redirect()->route('qualifications.index')->with('add', 'A qualification has been added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function show(Qualification $qualification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function edit(Qualification $qualification)
    {
        return view('candidate.edit-qualification', compact('qualification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qualification $qualification)
    {
        $qualification->update($request->merge(['candidate_id' => Auth::user()->id])->all());
        return redirect()->route('qualifications.index')->with('edit', 'Edited qualification successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qualification  $qualification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qualification $qualification)
    {
        $qualification->delete();
        return redirect()->route('qualifications.index')->with('delete', 'the qualification has been removed successfully');
    }
}
