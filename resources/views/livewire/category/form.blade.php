@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">


        <div class="input-group mb-3">
            <span class="input-group-text fas fa-edit" id="basic-addon1"></span>
            <input type="text" wire:model.lazy='name' class="form-control" placeholder="Category name"
                aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('name')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>
    <div class="col-sm-12 mt-3">


        <div class="col-sm-12 mt-1">
            <div class="mb-3">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" wire:model="image" id="formFile">
            </div>


            @if ($selected_id > 1 && !$image)
                <img src="{{ asset('storage/' . $currentImage) }}" alt="example" height="70" width="80"
                    class="rounded">
            @elseif($image)
                <img height="270" width="280" src="{{ $image->temporaryUrl() }}">
            @endif




            @error('image')
                <span class="error">{{ $message }}</span>
            @enderror


        </div>






        @error('image')
            <span class="text-danger er">{{ $message }}</span>
        @enderror

    </div>
</div>


@include('common.modalzFooter')
