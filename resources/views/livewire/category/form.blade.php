@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">


        <div class="input-group mb-3">
            <span class="input-group-text fas fa-edit" id="basic-addon1"></span>
            <input type="text" wire:model.lazy='name' class="form-control" placeholder="courses example"
                aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('name')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 mt-3">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Recipient's username"
                aria-label="Recipient's username" aria-describedby="button-addon2" wire:model='image'
                accept="image/x-png, image/gif, image/jpeg">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
        </div>
        <label for="" class="custom-file-label">Image {{ $image }}</label>




        @error('image')
            <span class="text-danger er">{{ $message }}</span>
        @enderror

    </div>
</div>


@include('common.modalFooter')
