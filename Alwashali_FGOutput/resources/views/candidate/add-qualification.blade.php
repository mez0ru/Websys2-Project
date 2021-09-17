@extends('layouts.master')
@extends('layouts.hirer_nav')

@section('title')
Add Qualifications
@endsection

@section('content')
    <h1 class="mt-4">Add Qualification</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Enhance your competence when you apply for a job by adding your qualifications you deserve here</li>
    </ol>

    <form action={{ route('qualifications.store') }} method="POST" class="mt-3">
        @csrf
    <div class="form-group">
      <label for="qualificationInput">Qualification:</label>
      <textarea class="form-control" id="qualificationInput" aria-describedby="qualification" placeholder="Enter your qualification" name="qualification"></textarea>
      <small id="qualificationhelp" class="form-text text-muted">Be concise & credible.</small>
    </div>
    <button type="submit" class="btn btn-primary mb-3" name="addForm">Add</button>
  </form>
@endsection