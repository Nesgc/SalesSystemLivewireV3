@include('common.modalHead')

<div class="row">

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Value</label>

            <input type="text" wire:model.lazy='value' class="form-control" placeholder="Value" aria-label="Username"
                aria-describedby="basic-addon1">
        </div>

        @error('value')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label for="">Type</label>
            <select wire:model="type" class="form-control">
                <option value="" disabled>Choose a type...</option>
                <option value="Bill">Bill</option>
                <option value="Coin">Coin</option>
                <option value="Other">Other</option>
            </select>
            @error('type')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>





    <div class="col-sm-12 mt-3">

        <div class="col-sm-12 mt-1">
            <div class="mb-3">
                <label for="formFile" class="form-label">Image</label>
                <input class="form-control" type="file" wire:model="image" id="formFile">
            </div>


            @if ($selected_id > 0 && !$image)
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
