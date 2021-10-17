<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\QualificationController;

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
		Route::view('appliedJobs', 'candidate.job-applied')
		->name('appliedJobs');
	});

	Route::group(['middleware' => 'role:candidate'], function() {
		Route::resource('qualifications', QualificationController::class);
	});

	Route::group(['middleware' => 'role:hirer'], function() {
		Route::view('statistics', 'hirer.statistics')
		->name('statistics');
	});
});