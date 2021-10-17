<div wire:ignore.self id="Confirmation" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-body p-0">
                <div class="card border-0 p-sm-3 p-2 justify-content-center">
                    <div class="card-header pb-0 bg-white border-0 ">
                        <div class="row">
                            <div class="col ml-auto"><button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click='resetInput'> <span aria-hidden="true">&times;</span> </button></div>
                        </div>
                        <p class="font-weight-bold mb-2" x-text="confirmText"></p>
                        <p class="text-muted ">You won't be able to undo after performing this action.</p>
                        <input type="number" wire:model="ids" hidden>
                    </div>
                    <div class="card-body px-sm-4 mb-2 pt-1 pb-0">
                        <div class="row justify-content-end no-gutters">
                            <div class="col-auto"><button type="button" class="btn btn-light text-muted" data-dismiss="modal" wire:click.prevent="resetInput">Cancel</button></div>
                            <div class="col-auto"><button style="margin-left:4px" type="button" class="btn btn-danger px-4" wire:click.prevent="confirmYes">Yes</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>