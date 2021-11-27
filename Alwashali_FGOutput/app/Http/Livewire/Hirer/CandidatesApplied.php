<?php

namespace App\Http\Livewire\Hirer;

use App\Models\JobPost;
use Livewire\Component;
use App\Models\JobApplied;
use App\TransactionStatus;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CandidatesApplied extends Component
{
    // pagination support
    use WithPagination;

    // authorization support
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    // used for identification
    public $ids;

    public $searchTerm;

    public $selectedApp;
    public $action;

    public $confirmMessage;

    public function mount($id)
    {
        $this->ids = $id;
    }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $job = JobPost::select(['title', 'hirer_id'])->find($this->ids);
        $this->authorize('view', $job);

        $title = $job->title;

        $apps = JobApplied::where('job_id', $this->ids)
            ->whereHas('candidate', function ($query) use (&$searchTerm) {
                $query->where('name', 'LIKE', $searchTerm)
                    ->orWhere('email', 'LIKE', $searchTerm);
            })

            ->orderBy('id', 'DESC');


        $count = $apps->count();

        // $apps = JobApplied::with(array('job.requirement'))
        // ->where('candidate_id', Auth::user()->id)
        // ->whereHas('job', function ($query) use(&$searchTerm) {
        //     $query->where('title','LIKE',$searchTerm)
        //     ->orWhere('description','LIKE',$searchTerm);
        // })
        // ->orderBy('id','DESC');

        // count
        // $totalRecords = $apps->count();
        // view
        return view('livewire.hirer.candidates-applied', [
            'applications' => $apps->paginate(5),
            'count' => $count,
            'title' => $title,
        ])->extends('layouts.app');
    }

    // To Reset The input fields
    public function resetInput()
    {
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('resetInput');
    }

    public function edit($id, $action)
    {
        $this->selectedApp = JobApplied::with('job')->find($id);
        $this->action = $action;

        // change message text
        switch ($action) {
            case 0:
                $this->confirmMessage = "You are about to interview an applicant, are you sure?";
                break;
            case 1:
                $this->confirmMessage = "You are about to dismiss an applicant, are you sure?";
                break;
            case 2:
                $this->confirmMessage = "You are about to accept an applicant for this job, are you sure?";
                break;

            default:
                # code...
                break;
        }
    }

    public function confirmYes() // when confirmation is affirmed
    {
        $this->authorize('update', $this->selectedApp);

        $this->selectedApp->update(['status' => TransactionStatus::UpgradeStatus($this->selectedApp->status, $this->action)]);
        $this->selectedApp->save();
        
        switch ($this->action) {
            case 0:
                session()->flash('message', 'accepted the applicants interview Successfully!');
                break;
            case 1:
                session()->flash('message', 'dismissed the applicant Successfully!');
                break;
                case 2:
                    session()->flash('message', 'appointed the applicant for the Job Successfully!');
                    break;
        }

        $this->resetInput();
        $this->emit('statusChange');
    }
}
