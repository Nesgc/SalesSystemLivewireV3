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


        <div class="col-sm-12 mt-3">

            <label for="formFile" class="form-label">Image {{ $image }}</label>
            <input wire:model='image' class="form-control" type="file" id="formFile"
                accept="image/x-png, image/gif, image/jpeg">

        </div>






        @error('image')
            <span class="text-danger er">{{ $message }}</span>
        @enderror

    </div>
</div>


@include('common.modalFooter')
