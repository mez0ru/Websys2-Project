@section('title')
{{ $title }}
@endsection
<div>
<h2 class="mt-4">Candidates currently applied for this job</h2>
<h6 class="mt-4 job-title">Job title: {{ $title }}</h6>
<h6 class="mt-2 candidates-counter">Candidates applied: {{ $count }}</h6>
<hr>
<div class="row">
  <div class="col-md-12">
      <div class="input-group mb-2 mt-2">
          <input name="search_box" id="search_box" type="text" class="form-control rounded"
              placeholder="Search" aria-label="Search" aria-describedby="search-addon"
              wire:model="searchTerm" />
          <div class="ml-3">
            @include('livewire.job-posts.confirm-modal')
          </div>
      </div>
  </div>
</div>
@if (session()->has('message'))
  <div id="successMsg">
      <div class="alert alert-primary" role="alert">
          <b>{{ session('message') }}</b>
      </div>
  </div>
@endif
<h6 class="mt-3">Click on a candidate's name to view his/her bio and qualifications.</h6>


<table class="table table-striped table-hover mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Gender</th>
      <th scope="col">Age</th>
      <th scope="col">Date Applied</th>
      <th scope="col">Last Status Change</th>
      <th scope="col">Status</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
      
    @forelse ($applications as $application)
    <tr class="{!! TransactionStatus::HirerGetColorByStatus($application->status) !!}">
        <th>{{ $loop->index + 1 }}</th>
        <td class="candidateRow" onclick="window.open('{{ route('view-candidate', $application->id) }}', '_blank')">{{ $application->candidate->name }}</td>
        <td>{{ $application->candidate->email }}</td>
        <td>{{ $application->candidate->gender }}</td>
        <td>{{ $application->candidate->age }}</td>
        <td>{{ $application->created_at }}</td>
        <td>{{ $application->updated_at }}</td>
        
        <td>{{ TransactionStatus::HirerGetNameOfStatus($application->status) }}</td>
        <td class="action-class">
          
            {!! TransactionStatus::HirerGetButtonsOfStatus($application->status, $application->id) !!}
            
          
        </td>
    </tr>
    @empty
    <p>No applicants applied yet!</p>
    @endforelse
  </tbody>
</table>

<tr class="pageRow">
  <td colspan="3">
     <div class="d-flex justify-content-center pt-4">
    {{ $applications->links() }}
  </div>
</td>
</tr>


@livewireScripts
<script src="{{ asset('js/candidatesList.js') }}"></script>
</div>
