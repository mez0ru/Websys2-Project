<?php

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Hirer\Statistics;
use App\Http\Livewire\Hirer\ShowCandidate;
use App\Http\Controllers\JobPostController;
use App\Http\Livewire\Hirer\CandidatesApplied;
use App\Http\Livewire\JobPosts\CandApplJobPosts;
use App\Http\Controllers\QualificationController;
use App\Http\Controllers\CandidatesAppliedController;
use App\Http\Controllers\PrintPDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('jobs', function () {
	return view('dashboard');
})->name('jobs');

Route::redirect('/', '/jobs', 301);
Route::view('dashboard', 'profile.profileSettings')
	->name('dashboard')
	->middleware(['auth', 'verified']);


Route::group(['middleware' => 'auth'], function() {
	Route::group(['middleware' => 'role:candidate'], function() {
		Route::get('appliedJobs', CandApplJobPosts::class)
		->name('appliedJobs');
		Route::resource('qualifications', QualificationController::class);
	});

	Route::group(['middleware' => 'role:hirer'], function() {
		Route::get('candidates-list-applied/{id}', CandidatesApplied::class);
		Route::get('statistics', Statistics::class)->name('statistics');
		Route::get('view-candidate/{id}', ShowCandidate::class)->name('view-candidate');
		Route::get('statistics/pdf', PrintPDFController::class)->name('pdf');
	});
});