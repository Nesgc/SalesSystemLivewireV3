@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-8">


        <div class="form-group">
            <label>Product Name</label>

            <input type="text" wire:model.lazy='name' class="form-control" placeholder="Product name"
                aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('name')
            <span class="text-danger er">{{ $message }}</span>
        @enderror

    </div>

    <div class="col-sm-12 col-md-4">


        <div class="form-group">
            <label>Barcode</label>
            <input type="text" wire:model.lazy='barcode' class="form-control" placeholder="Product barcode"
                aria-label="Username" aria-describedby="basic-addon1">

        </div>

        @error('barcode')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-4 mt-3 mt-3">

        <div class="form-group">
            <label for="">Cost</label>

            <input type="text" data-type="currency" wire:model.lazy='cost' class="form-control"
                placeholder="Product cost" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('cost')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-4 mt-3">

        <div class="form-group">
            <label for="">Price</label>

            <input type="text" data-type="currency" wire:model.lazy='price' class="form-control"
                placeholder="Product price" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('price')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-4 mt-3">

        <div class="form-group">
            <label for="">Stock</label>

            <input type="number" wire:model.lazy='stock' class="form-control" placeholder="Product stock"
                aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('stock')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>

    <div class="col-sm-12 col-md-6 mt-3">

        <div class="form-group">
            <label for="">Alerts</label>

            <input type="number" wire:model.lazy='alerts' class="form-control" placeholder="Product alerts"
                aria-label="Username" aria-describedby="basic-addon1">
        </div>

        @error('alerts')
            <span class="text-danger er">{{ $message }}</span>
        @enderror
    </div>


    <div class="col-sm-12 col-md-6 mt-3">
        <div class="form-group">
            <label for="">Categories</label>
            <select class="form-select" name="" id="" wire:model="category_id">
                <option value="Select">Select</option>
                @foreach ($products as $product)
                    <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-12 mt-3">


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
