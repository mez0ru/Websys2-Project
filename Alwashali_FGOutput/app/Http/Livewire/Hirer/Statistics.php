<?php

namespace App\Http\Livewire\Hirer;

use Livewire\Component;
use App\Models\JobApplied;
use App\TransactionStatus;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use GuzzleHttp\TransferStats;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Statistics extends Component
{

    // pagination support
    use WithPagination;

    // authorization support
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $searchTerm;

    // gender count
    public $maleCount;
    public $femaleCount;

    // status count
    public $applied;
    public $dismissed;
    public $cancelled;
    public $interview_requested;
    public $interviewing;
    public $accepted;

    // filter dialog info:
    public $appliedC = true;
    public $reqintC = true;
    public $intingC = true;
    public $accC = true;
    public $dismC = true;
    public $cancC = true;
    public $gender = 'both';
    public $df;
    public $dt;
    public $agef = 0;
    public $aget = 120;

    public $ids;

    public $isTabularActive = false;

    public $pdfData;

    public function render()
    {
        $this->pdfData = [];
        $this->pdfData['searchTerm'] = $searchTerm = '%' . $this->searchTerm . '%';

        if ($this->gender == 'both')
        $gender = ['Male', 'Female'];
        else
        $gender = [$this->gender];

        $this->pdfData['gender'] = $this->gender;

        $ageRange = [$this->pdfData['agef'] = $this->agef, $this->pdfData['aget'] = $this->aget];
        
        if (!is_null($this->df))
        $this->pdfData['df'] = date('Y-m-d 00:00:00', strtotime($this->df));
        if (!is_null($this->dt))
        $this->pdfData['dt'] =  date('Y-m-d 23:59:59', strtotime($this->dt));

        $statusRange = array();

        if ($this->appliedC){
            array_push($statusRange, TransactionStatus::APPLIED);
            $this->pdfData['applied'] = true;
        }
        if ($this->reqintC){
        array_push($statusRange, TransactionStatus::INTERVIEW_REQUESTED);
        $this->pdfData['reqint'] = true;
        }
        if ($this->intingC){
        array_push($statusRange, TransactionStatus::INTERVIEWING);
        $this->pdfData['inting'] = true;
    }
        if ($this->accC){
        array_push($statusRange, TransactionStatus::ACCEPTED);
        $this->pdfData['acc'] = true;
    }
        if ($this->dismC){
        array_push($statusRange, TransactionStatus::REJECTED);
        $this->pdfData['dism'] = true;
    }
    if ($this->cancC){
        array_push($statusRange, TransactionStatus::CANCELLED);
        $this->pdfData['canc'] = true;
    }

        //table
        $apps = JobApplied::with(['job', 'candidate'])
        ->whereHas('job', function ($query) use (&$searchTerm) {
            $query->where('hirer_id', Auth::user()->id);
        })
        ->where(function ($query) use (&$searchTerm, &$gender, &$ageRange, &$dateRange, &$statusRange){
            if ((array_key_exists('df', $this->pdfData) && array_key_exists('dt', $this->pdfData)))
                $query->whereBetween('created_at', [$this->pdfData['df'], $this->pdfData['dt']]);
            $query
            ->whereIn('status', $statusRange)
            ->whereHas('candidate', function ($query) use (&$searchTerm, &$gender, &$ageRange) {
                $query
                ->whereIn('gender', $gender)
                ->whereBetween('age', $ageRange)
                ;
            });
        })
        ->where(function ($query) use (&$searchTerm){
            $query->whereHas('job', function ($query) use (&$searchTerm) {
                $query->where('title', 'LIKE', $searchTerm);
            })
            ->orWhereHas('candidate', function ($query) use (&$searchTerm) {
                $query->where('name', 'LIKE', $searchTerm)
                ->orWhere('email', 'LIKE', $searchTerm)
                ->orWhere('gender', 'LIKE', $searchTerm)
                ->orWhere('age', 'LIKE', $searchTerm);
            });
            //->orWhere('status', 'LIKE', $searchTerm);
        })
        ->orderBy('id', 'DESC');

        // crate array
        $this->ids = array();

        foreach ($apps as $app)
            array_push($this->ids, $app->id);

        //$this->authorize('view', $job);

        if (is_null($this->maleCount)){ // If already fetched don't fetch again to save the processing power!
            $this->CountGender();
            $this->CountStatus();
        }

        $pieGenderChartModel = (new PieChartModel)
            ->setTitle('Distribution of applicants by Gender')
            ->addSlice('Male', $this->maleCount, '#90cdf4')
            ->addSlice('Female', $this->femaleCount, '#fc8181');

            $pieStatusChartModel = (new PieChartModel)
            ->setTitle('Distribution of applicants by Status')
            ->addSlice(TransactionStatus::HirerGetNameOfStatus(TransactionStatus::APPLIED), $this->applied, '#fffc38')
            ->addSlice(TransactionStatus::HirerGetNameOfStatus(TransactionStatus::REJECTED), $this->dismissed, '#ff3838')
            ->addSlice(TransactionStatus::HirerGetNameOfStatus(TransactionStatus::CANCELLED), $this->cancelled, '#ff69be')
            ->addSlice(TransactionStatus::HirerGetNameOfStatus(TransactionStatus::INTERVIEW_REQUESTED), $this->interview_requested, '#696eff')
            ->addSlice(TransactionStatus::HirerGetNameOfStatus(TransactionStatus::INTERVIEWING), $this->interviewing, '#38fff8')
            ->addSlice(TransactionStatus::HirerGetNameOfStatus(TransactionStatus::ACCEPTED), $this->accepted, '#3bff38');

        return view('livewire.hirer.statistics', [
            'pieGenderChartModel' => $pieGenderChartModel,
            'pieStatusChartModel' =>
            $pieStatusChartModel,
            'apps' => $apps->paginate(5)
        ])->extends('layouts.app');
    }

    public function tabChange($index){
        $this->isTabularActive = $index == 1;
    }

    public function generatePdf(){
        redirect()->away(route('pdf', $this->pdfData));
    }

    public function CountGender()
    {
        $this->maleCount = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
                'candidate' => function ($query) {
                    $query->select('gender');
                }
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->whereHas('candidate', function ($query) {
            $query->where('gender', 'Male');
        })->count();

        $this->femaleCount = JobApplied::with(array(
            'job' => function ($query) {
                $query->select('hirer_id');
            },
            'candidate' => function ($query) {
                $query->select('gender');
            }
        ))->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->whereHas('candidate', function ($query) {
            $query->where('gender', 'Female');
        })->count();
    }

    public function CountStatus()
    {
        $this->applied = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->where('status', TransactionStatus::APPLIED)->count();

        $this->dismissed = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->where(function($query){
            $query->where('status', TransactionStatus::REJECTED);
        })->count();

        $this->interview_requested = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->where('status', TransactionStatus::INTERVIEW_REQUESTED)->count();

        $this->cancelled = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->where('status', TransactionStatus::CANCELLED)->count();

        $this->interviewing = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->where('status', TransactionStatus::INTERVIEWING)->count();

        $this->accepted = JobApplied::with(
            array(
                'job' => function ($query) {
                    $query->select('hirer_id');
                },
            )
        )->whereHas('job', function ($query) {
            $query->where('hirer_id', Auth::user()->id);
        })->where('status', TransactionStatus::ACCEPTED)->count();
    }
}
