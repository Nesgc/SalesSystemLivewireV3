<div wire:ignore.self id="themodal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><b>{{ $componentName }}</b> |
                    {{ $selected_id > 0 ? 'Edit' : 'Create' }}</h5>
                <h6 class="text-center text-warning" wire:loading>Please wait...</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group mb-3">
                            <span class="input-group-text d-flex align-items-center fas fa-edit"
                                id="basic-addon1"></span>
                            <input type="text" wire:model.lazy='permissionName' class="form-control"
                                placeholder="Permission Name" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        @error('permissionName')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI" class="btn btn-dark close-btn text-info"
                    data-bs-dismiss="modal">Close</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">Save</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-dark close-modal">Update</button>
                @endif

            </div>
        </div>
    </div>
</div>
