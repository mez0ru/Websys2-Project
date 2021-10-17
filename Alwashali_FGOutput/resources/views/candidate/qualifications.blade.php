@extends('layouts.app')

@section('title')
    Qualifications
@endsection

@section('content')
    <h1 class="mt-4">Qualifications</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Enhance your competence when you apply for a job by adding your qualifications you deserve here</li>
    </ol>
    
    @if (Session::has('delete'))
    <div class="alert alert-danger deletealert" role="alert">
      {{ Session::get('delete') }}
    </div>
    @elseif (Session::has('add'))
    <div class="alert alert-primary addalert" role="alert">{{ Session::get('add') }}</div>
    @elseif (Session::has('edit'))
    <div class="alert alert-info editalert" role="alert">{{ Session::get('edit') }}</div>
    @endif

    <div class="d-grid gap-2">
      <a type="button" class="btn btn-primary" href="{{ route('qualifications.create') }}">Add Qualification</a>
    </div>
    
    <table class="table mt-5">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Qualification</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($qualifications as $qualification)
        <tr>
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td>{{ $qualification->qualification }}</td>
            <td>
                <a type="button" class="btn btn-info" href="{{ route('qualifications.edit', $qualification->id) }}">Edit</a>
                <form action="{{ route('qualifications.destroy', $qualification->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form></td>
            </tr>
        @endforeach
      </tbody>
    </table>

    <tr class="pageRow">
        <td colspan="3">
           <div class="d-flex justify-content-center pt-4">
          {{ $qualifications->links() }}
        </div>
      </td>

            {{-- <script src="{{ asset('js/qualifications.js') }}"></script> --}}
        @endsection