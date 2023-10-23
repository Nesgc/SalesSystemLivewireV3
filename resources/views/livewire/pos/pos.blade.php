<div>
    <style></style>
    <div class="row layout-top-spacing">
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
