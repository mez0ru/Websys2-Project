@extends('layouts.app')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Login</h3>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div>
                            {{ session('status') }}
                        </div>
                    @endif

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

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1">{{ __('Email') }}</label>
                            <input class="form-control py-4" type="email" name="email" value="{{ old('email') }}" required
                                autofocus />
                        </div>

                        <div class="form-group">
                            <label class="small mb-1">{{ __('Password') }}</label>
                            <input class="form-control py-4" type="password" name="password" required
                                autocomplete="current-password" />
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox"
                                    name="remember" />
                                <label class="custom-control-label"
                                    for="rememberPasswordCheck">{{ __('Remember me') }}</label>
                            </div>
                        </div>


                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('password.request'))
                                <a class="small"
                                    href="{{ route('password.request') }}">{{ __('Forgot your password?') }}</a>
                            @endif
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                        <div class="small"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
