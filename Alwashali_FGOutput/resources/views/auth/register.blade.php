@extends('layouts.app')
@section('content')
<div class="row justify-content-center mb-3">
    <div class="col-lg-7">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
            <div class="card-body">
                @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <div>{{ __('Whoops! Something went wrong.') }}</div>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="small mb-1">Full Name</label>
                        <input class="form-control py-4" type="text" placeholder="Enter your name" name="name" required autofocus/>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1">Email</label>
                        <input class="form-control py-4" type="email" aria-describedby="emailHelp" placeholder="Enter email address" name="email" required/>
                    </div>
                    <div class="form-group">
                        <label class="small mb-1">Select who you are</label>
                        <select class="form-control" name="role">
                            <option value="{{ Roles::HIRER }}">Hirer</option>
                            <option value="{{ Roles::CANDIDATE }}">Candidate</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1" >Password</label>
                                <input class="form-control py-4" type="password" placeholder="Enter password" name="password" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="small mb-1">Confirm Password</label>
                                <input class="form-control py-4" type="password" placeholder="Confirm password" name="password_confirmation"required/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">Create Account</button></div>
                </form>
            </div>
            <div class="card-footer text-center">
                <div class="small"><a href="{{ route('login') }}">Have an account? Go to login</a></div>
            </div>
        </div>
    </div>
</div>
@endsection