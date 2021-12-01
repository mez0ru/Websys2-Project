<?php

namespace App\Http\Controllers;

use App\Models\JobApplied;
use App\TransactionStatus;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrintPDFController extends Controller
{
    public function __invoke(Request $request){
        $fpdf = new Fpdf();
        $fpdf->AddPage('L');

$header = array('Full Name', 'Email', 'Gender', 'Age', 'Applied Date', 'Job Title', 'Status');
$fpdf->SetFont('Arial','',24);

$fpdf->Cell(0,30,'Tabular Report',0,0,'C',false);
$fpdf->Ln();
$fpdf->SetFont('Arial','',14);
date_default_timezone_set('Asia/Manila');
$fpdf->Cell(0,20,'Date: ' . date("F j, Y, g:i A"),0,0,'C',false);
$fpdf->Ln();
    // Colors, line width and bold font
    $fpdf->SetFont('Arial','',11);
    $fpdf->SetFillColor(0,96,192);
    $fpdf->SetTextColor(255);
    $fpdf->SetDrawColor(125,172,219);
    $fpdf->SetLineWidth(.3);
    $fpdf->SetFont('','B');
    // Header
    $w = array(45, 55, 16, 11, 42, 65, 38);
    for($i=0; $i < count($header); $i++)
        $fpdf->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $fpdf->Ln();
    // Color and font restoration
    $fpdf->SetFillColor(224,235,255);
    $fpdf->SetTextColor(0);
    $fpdf->SetFont('');
    // Data
    $fill = false;
    
    //query
        // status array
        $statusarr = array();
        if ($request->get('applied', false))
            array_push($statusarr, TransactionStatus::APPLIED);
        if ($request->get('reqint', false))
        array_push($statusarr, TransactionStatus::INTERVIEW_REQUESTED);
        if ($request->get('inting', false))
        array_push($statusarr, TransactionStatus::INTERVIEWING);
        if ($request->get('acc', false))
        array_push($statusarr, TransactionStatus::ACCEPTED);
        if ($request->get('dism', false))
        array_push($statusarr, TransactionStatus::APPLIED_DISMISSED, TransactionStatus::INTERVIEW_REQUESTED_REJECTED, TransactionStatus::INTERVIEWING_REJECTED);

        $gender = $request->get('gender');
        if ($gender == 'both')
            $gender = array('Male', 'Female');
        else
            $gender = array($gender);


    $apps = JobApplied::with(['job', 'candidate'])
    ->whereHas('job', function ($query) {
        $query->where('hirer_id', Auth::user()->id);
    })
    ->where(function ($query) use (&$request, &$statusarr, &$gender){
        if (!(is_null($request->get('df')) && is_null($request->get('dt'))))
            $query->whereBetween('created_at', [$request->get('df'), $request->get('dt')]);
        $query
        ->whereIn('status', $statusarr)
        ->whereHas('candidate', function ($query) use (&$request, &$gender) {
            $query
            ->whereIn('gender', $gender)
            ->whereBetween('age', [$request->get('agef'), $request->get('aget')])
            ;
        });
    })
    ->where(function ($query) use (&$request){
        $query->whereHas('job', function ($query) use (&$request) {
            $query->where('title', 'LIKE', $request->get('searchTerm'));
        })
        ->orWhereHas('candidate', function ($query) use (&$request) {
            $query->where('name', 'LIKE', $request->get('searchTerm'))
            ->orWhere('email', 'LIKE', $request->get('searchTerm'))
            ->orWhere('gender', 'LIKE', $request->get('searchTerm'))
            ->orWhere('age', 'LIKE', $request->get('searchTerm'));
        });
        //->orWhere('status', 'LIKE', $searchTerm);
    })
    ->orderBy('id', 'DESC')
    ->get();


    foreach($apps as $app)
    {
        $fpdf->Cell($w[0],6,$app->candidate->name,'LR',0,'L',$fill);
        $fpdf->Cell($w[1],6,$app->candidate->email,'LR',0,'L',$fill);
        $fpdf->Cell($w[2],6,$app->candidate->gender,'LR',0,'L',$fill);
        $fpdf->Cell($w[3],6,$app->candidate->age,'LR',0,'L',$fill);
        $fpdf->Cell($w[4],6,$app->created_at,'LR',0,'L',$fill);
        $fpdf->Cell($w[5],6,$app->job->title,'LR',0,'L',$fill);
        switch ($app->status) {
            case TransactionStatus::APPLIED:
                $status = 'Applied';
                break;
                case TransactionStatus::INTERVIEW_REQUESTED:
                    $status = 'Requested interview';
                    break;
                    case TransactionStatus::INTERVIEWING:
                        $status = 'In the interview';
                        break;
                        case TransactionStatus::ACCEPTED:
                            $status = 'Accepted';
                            break;

            
            default:
            $status = 'Failed / Dismissed';
                break;
        }
        $fpdf->Cell($w[6],6,$status,'LR',0,'L',$fill);
        $fpdf->Ln();
        $fill = !$fill;
    }
    // Closing line
    $fpdf->Cell(array_sum($w),0,'','T');

    return response($fpdf->Output(), 200)->header('Content-Type', 'application/pdf');
    }
}
