<?php

namespace App\Http\Livewire\JobPosts;

use App\Roles;
use App\Models\JobPost;
use Livewire\Component;
use App\Models\JobApplied;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CandDisJobPosts extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    // modal inputs
    public $job_id;

    public $searchTerm;
    public $confirmMessage = 'You are about to apply for this job post, are you sure?';
    public $count;

    // public function __construct()
    // {
    // }

    public function render()
    {
        $searchTerm = '%'.$this->searchTerm.'%';

        if (Auth::check() && Auth::user()->role == Roles::CANDIDATE){
        $jobs = JobPost::with(array('requirement', 'applied'))->whereDoesntHave('applied', function ($q) {
            $q->where('candidate_id', Auth::user()->id);
        })
        ->where(function ($query) use(&$searchTerm) {
            $query->where('title','LIKE',$searchTerm)
            ->orWhere('description','LIKE',$searchTerm);
        })
        ->orderBy('id','DESC');
    } else {
        $jobs = JobPost::with(['requirement', 'applied'])
        ->where('title','LIKE',$searchTerm)
        ->orWhere('description','LIKE',$searchTerm)->orderBy('id','DESC');
    }

        // count
        $totalRecords = $jobs->count();

        // view
        return view('livewire.job-posts.cand-dis-job-posts',[
            'jobs' => $jobs->paginate(2),
            'totalRecords' => $totalRecords
        ]);
    }

    // To Reset The input fields
    public function resetInput()
    {
        $this->job_id = '';
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('resetInput');
    }

    public function edit($id)
    {
        $job = JobPost::find($id);
        $this->job_id = $job->id;
    }

    public function confirmYes() // when confirmation is affirmed
    {
        $this->authorize('create', JobApplied::class);

        JobApplied::create([
            'candidate_id' => Auth::user()->id,
            'job_id' => $this->job_id,
        ]);

        session()->flash('message', 'Job Applied Successfully!');
        $this->resetInput();
        $this->emit('jobAdded');
    }
}
