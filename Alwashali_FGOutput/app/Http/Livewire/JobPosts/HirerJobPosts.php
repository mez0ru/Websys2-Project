<?php

namespace App\Http\Livewire\JobPosts;

use App\Models\JobPost;
use Livewire\Component;
use App\Models\Requirement;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class HirerJobPosts extends Component
{
    use WithPagination;
    use AuthorizesRequests;
    protected $paginationTheme = 'bootstrap';

    // modal inputs
    public $job_id;
    public $req_id;
    public $title;
    public $description;
    public $from;
    public $to;
    public $until;
    public $social;
    public $gender;
    public $age;
    public $exp;
    public $qual;

    public $searchTerm;
    public $count;

    // public function __construct()
    // {
    // }

    public function render()
    {
        $this->authorize('viewAny', JobPost::class);

        // search implementation
        $searchTerm = '%'.$this->searchTerm.'%';
        $jobs = JobPost::with('requirement')
        ->where('hirer_id', Auth::user()->id)
        ->where(function ($query) use(&$searchTerm) {
            $query->where('title','LIKE',$searchTerm)
            ->orWhere('description','LIKE',$searchTerm);
        })
        ->orderBy('id','DESC');

        // count
        $totalRecords = $jobs->count();

        // view
        return view('livewire.job-posts.hirer-job-posts',[
            'jobs' => $jobs->paginate(2),
            'totalRecords' => $totalRecords
        ]);
    }

    // To Reset The input fields
    public function resetInput()
    {
        $this->job_id = '';
        $this->req_id = '';
        $this->title = '';
        $this->description = '';
        $this->from = '';
        $this->to = '';
        $this->until = '';
        $this->gender = '';
        $this->social = '';
        $this->qual = '';
        $this->exp = '';
        $this->age = '';
        $this->resetErrorBag();
        $this->resetValidation();
        $this->emit('resetInput');
    }

    public function edit($id)
    {
        $job = JobPost::with('requirement')->where('id', $id)->first();
        $this->job_id = $id;
        $this->title = $job->title;
        $this->description = $job->description;
        $this->from = $job->salary_from;
        $this->to = $job->salary_to;
        $this->until = $job->apply_until;
        $this->social = $job->social;
        $this->req_id = $job->requirement->id;
        $this->gender = $job->requirement->gender;
        $this->qual = $job->requirement->qualifications;
        $this->exp = $job->requirement->min_work_experience;
        $this->age = $job->requirement->age;
    }

    public function update()
    {
        // validate
        $validatedData= $this->validate([
            'title'=>'required|string|max:255',
            'description'=>'required',
            'from'=>'required|integer',
            'to'=>'required|integer',
            'until'=>'required',
            'gender'=>'required',
            'social'=>'required|string',
            'qual'=>'required|string',
            'exp'=>'required|integer',
            'age'=>'required|integer',
        ]);

        if (empty($this->job_id))
            $this->authorize('create', JobPost::class);
        else
            $this->authorize('update', JobPost::find($this->job_id));

        $req = Requirement::updateOrCreate([
            'id' => $this->req_id,
        ], [
            'gender' => $this->gender,
            'qualifications' => $this->qual,
            'min_work_experience' => $this->exp,
            'age' => $this->age,
        ]);
        
        JobPost::updateOrCreate([
            'id' => $this->job_id,
        ], [
            'title' => $this->title,
            'description' => $this->description,
            'salary_from' => $this->from,
            'salary_to' => $this->to,
            'requirement_id' => $req->id,
            'apply_until' => $this->until,
            'social' => $this->social,
            'hirer_id' => Auth::user()->id,
        ]);

        if (empty($this->job_id)){
            session()->flash('message','Job Added Successfully!');
        $this->emit('jobAdded'); 
        } else {
        session()->flash('message', 'Job Updated Successfully!');
            $this->emit('jobUpdated');
        }

        $this->resetInput();
    }

    public function confirmYes() // when delete action is confirmed
    {
        $this->authorize('delete', JobPost::find($this->job_id));
        JobPost::where('id', $this->job_id)->delete();
        session()->flash('message', 'Job Deleted Successfully!');
        $this->resetInput();
        $this->emit('jobDeleted');
    }
}
