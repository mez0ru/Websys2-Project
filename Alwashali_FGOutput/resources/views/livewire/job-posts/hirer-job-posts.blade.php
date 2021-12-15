<div>
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Job Postings</li>
    </ol>

    <legend class="mt-3 post-count">You have {{ $totalRecords }} job posting(s).</legend>

    <div class="row">
        <div class="col-md-12">
            <div class="input-group mb-2 mt-2">
                <input name="search_box" id="search_box" type="text" class="form-control rounded"
                    placeholder="Search" aria-label="Search" aria-describedby="search-addon"
                    wire:model="searchTerm" />
                <div class="ml-3">
                    @include('livewire.job-posts.create-job-modal')
                    @include('livewire.job-posts.edit-job-modal')
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
    
    <div class="row mt-3">
        <div class="col-12 cards" data-userid="0">
    @forelse ($jobs as $job)
<div class="card shadow p-3 mb-3 bg-white rounded">
    <div class="card-body">
    <div class="row p-1 px-2 pb-sm-1 pb-md-1">
    <div class="col-sm-3 col-6 order-2 order-sm-1">
        <p class="mb-0">
        <small class="text-muted font-italic date-posted">Date Posted: {{ $job->created_at }}</small>
  </p>
  <p><small class="text-muted font-italic mb-md-5 mb-4 apply-until">Apply Until: {{ $job->apply_until }}</small></p>
  <p class="my-sm-3">
                          <a href="#" class="btn btn-success d-block mb-2 edit-btn" data-id="{{ $job->id }}" data-toggle="modal" data-target="#editJobModal" wire:click="edit({{$job->id}})"><i class="align-middle edit-job"></i> Edit</a>
                          <a href="#" class="btn btn-danger d-block mb-2 delete-btn" data-toggle="modal" data-target="#Confirmation" wire:click="edit({{$job->id}})"><i class="align-middle delete-job"></i> Delete</a>
                      </p>
                      <h6 class="mt-sm-4">Social Media:</h6>
                      <p class="social-dis">{!! nl2br($job->social) !!}</p>
      </div>
      <div class="col-sm-9 col-6 order-2 order-sm-1">
      <div class="col-12-sm">
      <a href="candidates-list-applied/{{ $job->id }}">
                              <h5 class="font-weight-bold text-primary post-title">{{ $job->title }}</h5>
                          </a>
      </div>
      <span class="badge badge-light rounded align-middle mb-2 min-work-exp">Min. Experience: {{ $job->requirement->min_work_experience }} year(s)</span>
      <div class="row mt-2">
      <div class="col-md-12">
          <p class="jobdescription">{!! nl2br($job->description) !!}</p>
      </div>
      <div class="col-md-12">
          <p class="qualifications"><b>Requirements:</b><br>{!! nl2br($job->requirement->qualifications) !!}</p>
      </div>

      <div class="col-md-12">
          <p class="mx-sm-0 my-0">
              <small class="badge badge-light gender">Gender: {{ $job->requirement->gender }}</small>
                          <small class="badge badge-light mt-1 age-dis">{{ $job->requirement->age }} years old and above</small>
                      </p>
      </div>
      <div class="col-md-12">
          <p class="mx-sm-0 my-0">
              <small class="badge badge-warning min-sal">Minimum salary: {{ $job->salary_from }}₱</small>
                          <small class="badge badge-warning mt-1 max-sal">Maximum salary: {{ $job->salary_to }}₱</small>
                      </p>
      </div>
  </div>
  </div>
  </div>
    </div>
    </div>
@empty
    <h5 class="noposts">You don't have any job postings.</h5>
@endforelse

  <tr class="pageRow">
    <td colspan="3">
       <div class="d-flex justify-content-center pt-4">
      {{ $jobs->links() }}
    </div>
  </td>
  </tr>
</div>
</div>
</div>