@extends('layouts.master')
@extends('layouts.hirer_nav')

@section('title')
    Dashboard
@endsection

@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Job Postings</li>
    </ol>
    
    @if (app('request')->input('delete'))
    <div class="alert alert-danger deletealert" role="alert">
      {{ app('request')->input('delete') }}
    </div>
    @endif

    <div class="alert alert-primary addalert" role="alert" hidden>Added new job posting successfully!</div>

    <div class="alert alert-info editalert" role="alert" hidden>edited the job posting successfully!</div>
    
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addJobModal">Create a new job
        posting</button>
    <legend class="mt-3 post-count">You have {{ $count }} job posting(s).</legend>
    <div class="row mt-3">
        <div class="col-12 cards" data-userid="0">

            <x-jobpost :jobs="$jobs" />
        </div>
    </div>

            <!-- Modal confirm -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmation" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmation">Confirmation</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label class="col-form-label message" style="white-space: pre-line;"></label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-danger" id="confirmactionbtn">Yes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="AddNewJob" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create new job posting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <ul class="errorMessages"></ul>
                                <div class="form-group">
                                    <label for="titleInput" class="col-form-label">Job Title:</label>
                                    <input type="text" class="form-control" id="titleInput" required>
                                </div>
                                <div class="form-group">
                                    <label for="job-description" class="col-form-label">Description:</label>
                                    <textarea class="form-control" id="job-description" required></textarea>
                                </div>
                                <h5>Salary</h5>
                                <div class="row mt-2">
                                    <div class="col-lg">
                                        <label for="salary-from">From</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="money">₱</span>
                                            </div>
                                            <input type="number" class="form-control" id="salary-from"
                                                placeholder="Minimum salary" aria-label="salary from"
                                                aria-describedby="money" min="0" max="1000000000" value="0" required>
                                        </div>
                                    </div>
                                    <div class="col-lg">
                                        <label for="salary-to">To</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="money">₱</span>
                                            </div>
                                            <input type="number" class="form-control" id="salary-to"
                                                placeholder="Maximum salary" aria-label="salary to" aria-describedby="money"
                                                min="0" max="1000000000" value="1000" required>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label for="apply-until" class="col-form-label">Job will be open until:</label>
                                    <input class="form-control datepicker" id="apply-until" type="date"
                                        data-provide="datepicker" placeholder="yyyy-mm-dd" required></input>
                                </div>
                                <div class="form-group">
                                    <label for="social-media-accounts" class="col-form-label">Social media accounts:</label>
                                    <textarea class="form-control" id="social-media-accounts" required></textarea>
                                </div>
                                <legend>Requirements</legend>
                                <div class="row mt-2">
                                    <div class="col-lg">
                                        <label for="gender-select">Gender:</label>
                                        <select class="form-control" id="gender-select" required>
                                            <option value="val1">Male</option>
                                            <option value="val2">Female</option>
                                            <option value="val3">Any</option>
                                        </select>
                                    </div>
                                    <div class="col-lg">
                                        <label for="age">Age</label>
                                        <input class="form-control" id="age" placeholder="Required Age" value="18"
                                            type="number" max="120" min="0" required></input>
                                    </div>
                                    <div class="col-lg">
                                        <label for="min-work-exp">Minimum work experience:</label>
                                        <input class="form-control" id="min-work-exp"
                                            placeholder="Minimum work experience (years):" value="0" type="number" max="50"
                                            min="0" required></input>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="qualifications" class="col-form-label">Requirements /
                                        Qualifications:</label>
                                    <textarea class="form-control" id="qualifications" required></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" id="sendbutton">Create</button>
                        </div>
                    </div>
                </div>
            </div>

            <script src="{{ asset('js/hirerDashboard.js') }}"></script>
        @endsection
