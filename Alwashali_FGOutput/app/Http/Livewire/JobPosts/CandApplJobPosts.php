<?php

namespace App\Http\Livewire\JobPosts;

use Livewire\Component;
use App\Models\JobApplied;
use App\TransactionStatus;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CandApplJobPosts extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    // modal inputs
    public $app_id;

    public $searchTerm;
    public $count;
    public $signal;
    public $status;
    public $confirmMessage;

    // public function __construct()
    // {
    // }

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';

        $apps = JobApplied::with(array('job.requirement'))
            ->where('candidate_id', Auth::user()->id)
            ->whereHas('job', function ($query) use (&$searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhere('description', 'LIKE', $searchTerm);
            })
            ->orderBy('id', 'DESC');

        // count
        $totalRecords = $apps->count();

        // view
        return view('livewire.job-posts.cand-appl-job-posts', [
            'apps' => $apps->paginate(2),
            'totalRecords' => $totalRecords
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

    public function edit($id, $signal)
    {
        $job = JobApplied::find($id);
        $this->app_id = $job->id;
        $this->status = $job->status;
        $this->signal = $signal; // 1 => Delete, 0 => update status

        switch ($signal) {
            case 0:
                $this->confirmMessage = 'You are about to accept an interview invitation, are you sure?';
                break;
            case 1:
                $this->confirmMessage = 'You are about to cancel your application, are you sure?';
                break;
        }
    }

    public function confirmYes() // when confirmation is affirmed
    {
        $app = JobApplied::find($this->app_id);
        $this->authorize('update', $app);

        $app->update(['status' => TransactionStatus::UpgradeStatus($this->status, $this->signal)]);
        $app->save();

        if ($this->signal == 1)
            session()->flash('message', 'Cancelled the Job Successfully!');
        else
            session()->flash('message', 'Job interview has been accepted!');

        $this->resetInput();
        $this->emit('statusChange');
    }
}
