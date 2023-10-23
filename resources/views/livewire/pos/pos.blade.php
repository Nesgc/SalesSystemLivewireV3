<div>
    <style></style>

    <div class="row layout-top-spacing">


        <div class="d-flex flex-row form-group mr-5 ">
            <div>
                <input type="text" wire:model.lazy='barcode' wire:keydown.enter.prevent='ScanCode()'
                    class="form-control d-flex col-sm-4 col-md-12 col-lg-12" placeholder="Product barcode"
                    aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <button type="button" wire:click.prevent="ScanCode()" class="btn btn-dark col-lg-1 mx-2">Save</button>
        </div>



        <div class="col-sm-12 col-md-8">
            <!--DETALLES-->
            @include('livewire.pos.partials.detail')


        </div>

        <div class="col-sm-12 col-md-4">
            <!--TOTAL-->
            @include('livewire.pos.partials.total')

            <!--DENOMIACIONES-->
            @include('livewire.pos.partials.coins')
        </div>
    </div>
</div>

<script src="{{ asset('js/keypress.js') }}"></script>
<script src="{{ asset('js/onscan.js') }}"></script>

@include('livewire.pos.partials.scripts.shortcuts')
@include('livewire.pos.partials.scripts.events')
@include('livewire.pos.partials.scripts.general')
@include('livewire.pos.partials.scripts.scan')


<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('scan-code', action => {
            $('#code').val('')
        });

    });
</script>
