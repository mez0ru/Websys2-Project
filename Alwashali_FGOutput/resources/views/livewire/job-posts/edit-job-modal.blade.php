<div>    
    <div wire:ignore.self class="modal fade" id="editJobModal" tabindex="-1" aria-labelledby="EditJob" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit job posting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="update">
                <div class="modal-body">
                        <div class="form-group">
                            <label for="titleInput" class="col-form-label">Job Title:</label>
                            <input type="text" class="form-control" wire:model="title" required>
                            @error('title') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="job-description" class="col-form-label">Description:</label>
                            <textarea class="form-control" wire:model="description" required></textarea>
                            @error('description') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <h5>Salary</h5>
                        <div class="row mt-2">
                            <div class="col-lg">
                                <label for="salary-from">From</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₱</span>
                                    </div>
                                    <input type="number" class="form-control"
                                        placeholder="Minimum salary" aria-label="salary from"
                                        aria-describedby="money" min="0" max="1000000000" value="0" wire:model="from" required>
                                </div>
                                @error('from') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                                
                            </div>
                            <div class="col-lg">
                                <label for="salary-to">To</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">₱</span>
                                    </div>
                                    <input type="number" class="form-control"
                                        placeholder="Maximum salary" aria-label="salary to" aria-describedby="money"
                                        min="0" max="1000000000" value="1000" wire:model="to" required>
                                </div>
                                @error('to') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="apply-until" class="col-form-label">Job will be open until:</label>
                            <input class="form-control datepicker" type="date"
                                data-provide="datepicker" placeholder="yyyy-mm-dd" wire:model="until" required>
                                @error('until') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="social-media-accounts" class="col-form-label">Social media accounts:</label>
                            <textarea class="form-control" wire:model="social" required></textarea>
                            @error('social') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <legend>Requirements</legend>
                        <div class="row mt-2">
                            <div class="col-lg">
                                <label for="gender-select">Gender:</label>
                                <select class="form-control" wire:model="gender" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Both">Both</option>
                                </select>
                                @error('gender') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="col-lg">
                                <label for="age">Age</label>
                                <input class="form-control" placeholder="Required Age" value="18"
                                    type="number" max="120" min="0" wire:model="age" required></input>
                                    @error('age') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                            </div>
                            <div class="col-lg">
                                <label for="min-work-exp">Minimum work experience:</label>
                                <input class="form-control"
                                    placeholder="Minimum work experience (years):" value="0" type="number" max="50"
                                    min="0" wire:model="exp" required></input>
                                    @error('exp') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qualifications" class="col-form-label">Requirements /
                                Qualifications:</label>
                            <textarea class="form-control" wire:model="qual" required></textarea>
                            @error('qual') <span style="color: red" class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    </div>