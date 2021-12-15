<div>
    @section('title')
        {{ 'Statistics and Reports' }}
    @endsection
    <h1 class="my-4">Statistics</h1>
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#filterModal">Filter</button>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a 
            @if ($isTabularActive)
            class="nav-link" href="#"
            @else
            class="nav-link active" 
            @endif wire:click="tabChange(0)">Charts</a>
        </li>
        <li class="nav-item">
            <a 
            @if ($isTabularActive)
            class="nav-link active" 
            @else
            class="nav-link" href="#"
            @endif wire:click="tabChange(1)">Tabular report</a>
        </li>
    </ul>
    <div id="tabularReportContainer" class="mb-4"
    @if (!$isTabularActive)
    style="display: none"
    @endif
    >
        <div class="row">
            <div class="col-md-12">
                <div class="input-group mb-2 mt-2">
                    <input name="search_box" id="search_box" type="text" class="form-control rounded"
                        placeholder="Search" aria-label="Search" aria-describedby="search-addon"
                        wire:model="searchTerm" />
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
          <h6 class="mt-3 mb-3">Click on a candidate's name to view his/her bio and qualifications.</h6>

        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Age</th>
                    <th scope="col">Applied Date</th>
                    <th scope="col">Job Applied</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody id="tableReport">
                @forelse ($apps as $application)
                    <tr class="{!! TransactionStatus::HirerGetColorByStatus($application->status) !!}">
                        <th>{{ $loop->index + 1 }}</th>
                        <td class="candidateRow"
                            onclick="window.open('{{ route('view-candidate', $application->id) }}', '_blank')">
                            {{ $application->candidate->name }}</td>
                        <td>{{ $application->candidate->email }}</td>
                        <td>{{ $application->candidate->gender }}</td>
                        <td>{{ $application->candidate->age }}</td>
                        <td>{{ $application->created_at }}</td>
                        <td>{{ $application->job->title }}</td>
                        <td>{{ TransactionStatus::HirerGetNameOfStatus($application->status) }}</td>
                    </tr>
                @empty
                    <p>Nothing to report!</p>
                @endforelse
            </tbody>
        </table>

        <tr class="pageRow">
            <td colspan="3">
               <div class="d-flex justify-content-center pt-4">
              {{ $apps->links() }}
            </div>
          </td>
          </tr>
        <button type="button" class="btn btn-primary mt-3" wire:click="generatePdf">Generate
            PDF</button>
    </div>

    <div id="chartContainer" class="mb-4"
    @if ($isTabularActive)
    style="display: none"
    @endif>
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Candidates applied distribution by status
                    </div>
                    <div class="card-body">
                        {{-- <canvas id="candidatesByStatusChart" width="100%" height="20"></canvas> --}}
                        <div style="height: 32rem;">
                            <livewire:livewire-pie-chart :pie-chart-model="$pieStatusChartModel" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Candidates applied distribution by gender
                    </div>
                    <div class="card-body">
                        <div style="height: 32rem;">
                            <livewire:livewire-pie-chart :pie-chart-model="$pieGenderChartModel" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModal" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form wire:submit.prevent="filter">
                <div class="modal-header">
                    <h5 class="modal-title">Filter results</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                        <ul class="errorMessages"></ul>
                        <div class="row mt-2">
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-header">
                                        Status
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="appliedC" id="appliedC"
                                                checked>
                                            <label class="form-check-label" for="appliedC">
                                                Applied
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="reqintC" id="requestedC"
                                                checked>
                                            <label class="form-check-label" for="requestedC">
                                                Requested interview
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="intingC" id="interviewC"
                                                checked>
                                            <label class="form-check-label" for="interviewC">
                                                In the interview
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="accC" id="acceptedC"
                                                checked>
                                            <label class="form-check-label" for="acceptedC">
                                                Accepted
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="dismC" id="failedC"
                                                checked>
                                            <label class="form-check-label" for="failedC">
                                                Rejected
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" wire:model="cancC" id="cancC"
                                                checked>
                                            <label class="form-check-label" for="cancC">
                                                Cancelled
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-header">
                                        Gender
                                    </div>
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="Male" wire:model="gender">
                                            <label class="form-check-label" for="maleC">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                            value="Female" wire:model="gender">
                                            <label class="form-check-label" for="femaleC">
                                                Female
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" value="both" wire:model="gender"
                                                checked>
                                            <label class="form-check-label" for="bothC">
                                                Both
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-header">
                                        Applied Date
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="dateFrom" class="col-form-label">Date From:</label>
                                            <input type="date" class="form-control" wire:model="df">
                                        </div>
                                        <div class="form-group">
                                            <label for="dateTo" class="col-form-label">Date To:</label>
                                            <input type="date" class="form-control" wire:model="dt"  min="{{ $df }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-header">
                                        Age
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="ageFrom" class="col-form-label">Age From:</label>
                                            <input type="number" class="form-control" wire:model="agef" min="0" max="120"
                                                value="0">
                                        </div>
                                        <div class="form-group">
                                            <label for="dateTo" class="col-form-label">Age To:</label>
                                            <input type="number" class="form-control" wire:model="aget" min="{{ $agef }}" max="120"
                                                value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <livewire:scripts />
    @livewireChartsScripts
    <script src="{{ asset('js/reports.js') }}"></script>
</div>
