<?php

namespace App\Http\Livewire\Hirer;

use Livewire\Component;
use App\Models\JobApplied;
use App\TransactionStatus;
use App\Models\Qualification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShowCandidate extends Component
{
    // authorization support
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    // used for identification
    public $ids;

    public $confirmMessage;
    public $searchTerm;
    public $action;
    public $app;

    public function mount($id)
    {
        $this->ids = $id;
    }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';

        $this->app = JobApplied::with(['job', 'candidate'])->find($this->ids);

        $this->authorize('view', $this->app);

        $qualifications = Qualification::where('candidate_id', $this->app->candidate_id)
        ->where(function ($query) use(&$searchTerm) {
            $query->where('qualification','LIKE',$searchTerm)
            ->orWhere('created_at','LIKE',$searchTerm)
            ->orWhere('updated_at','LIKE',$searchTerm);
        })->paginate(5);

        return view('livewire.hirer.show-candidate', 
    [
        'app' => $this->app,
        'qualifications' => $qualifications,
        ])->extends('layouts.app');
    }

    // To Reset The input fields
    public function resetInput()
    {
        $this->app_id = '';
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('resetInput');
    }

    public function edit($dummy, $action)
    {
        $this->action = $action; // 1 => Delete, 0 => update status

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
        $this->authorize('update', $this->app);

        $this->app->update(['status' => TransactionStatus::HirerUpgradeStatus($this->app->status, $this->action)]);
        $this->app->save();
        
        switch ($this->action) {
            case 0:
                session()->flash('message', 'accepted the applicant\'s interview Successfully!');
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
