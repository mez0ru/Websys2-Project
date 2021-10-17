@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
@guest
<livewire:job-posts.cand-dis-job-posts />
@endguest
@auth
@switch(Auth::user()->role)
@case(Roles::HIRER)
<livewire:job-posts.hirer-job-posts />
@break
@case(Roles::CANDIDATE)
<livewire:job-posts.cand-dis-job-posts />
@break
@default
<livewire:job-posts.cand-dis-job-posts />
@endswitch
@endauth
            
            @livewireScripts
            @if (Auth::check() && Auth::user()->role == Roles::HIRER)
            <script src="{{ asset('js/hirerDashboard.js') }}"></script>
            @else
            <script src="{{ asset('js/discoverJobs.js') }}"></script>
            @endif
            
        @endsection
