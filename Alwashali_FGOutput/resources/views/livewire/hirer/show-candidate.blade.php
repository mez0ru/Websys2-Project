@section('title')
{{ $app->candidate->name }}
@endsection
<div>
<h2 class="mt-4">Candidate Information</h2>
@if (session()->has('message'))
  <div id="successMsg">
      <div class="alert alert-primary" role="alert">
          <b>{{ session('message') }}</b>
      </div>
  </div>
@endif
<h6 class="mt-4">Applied job title: {{ $app->job->title }}</h6>
<h6 class="mt-3">Date applied: {{ $app->created_at }}</h6>
<h6 class="mt-3">Last status change: {{ $app->updated_at }}</h6>
<h6 class="mt-3">Name: {{ $app->candidate->name }}</h6>
<h6 class="mt-3">Email: {{ $app->candidate->email }}</h6>

<div class="d-flex flex-row mt-3">
        <h4>Current status of the applicant: </h4>
        <div class="ml-2"></div>
        <h4 class="{!! TransactionStatus::HirerGetColorByStatus($app->status) !!}">{{ TransactionStatus::HirerGetNameOfStatus($app->status) }}</h4>
</div>
<div class="mt-4">
    <label class="mr-4 font-weight-bold">Available actions:</label>
      
        {!! TransactionStatus::HirerGetButtonsOfStatus($app->status, $app->id) !!}
</div>
<hr>
<div class="row">
  <div class="col-md-12">
      <div class="mb-2 mt-2">
          <label for="search_box">Search Qualifications:</label>
          <input name="search_box" id="search_box" type="text" class="form-control rounded"
              placeholder="Search" aria-label="Search" aria-describedby="search-addon"
              wire:model="searchTerm" />
          <div class="ml-3">
            @include('livewire.job-posts.confirm-modal')
          </div>
      </div>
  </div>
</div>

<h6 class="mt-3">Candidate currently have these qualifications:</h6>


<table class="table table-striped table-hover mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Qualification</th>
      <th scope="col">Added Date</th>
      <th scope="col">Changed Date</th>
    </tr>
  </thead>
  <tbody>
      
    @forelse ($qualifications as $q)
    <tr>
        <th scope="row">{{ $loop->index + 1 }}</th>
        <td>{{ $q->qualification }}</td>
        <td>{{ $q->created_at }}</td>
        <td>{{ $q->updated_at }}</td>
    </tr>
    @empty
    <p>No applicants applied yet!</p>
    @endforelse
  </tbody>
</table>

<tr class="pageRow">
    <td colspan="3">
       <div class="d-flex justify-content-center pt-4">
      {{ $qualifications->links() }}
    </div>
  </td>
  </tr>

@livewireScripts
<script src="{{ asset('js/candidatesList.js') }}"></script>
</div>
