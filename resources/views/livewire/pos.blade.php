<div>

    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-8">

            {{-- Details --}}
            @include('livewire.pos.partials.detail')

        </div>
        <div class="col-sm-12 col-md-4">

            {{-- Total --}}
            @include('livewire.pos.partials.total')

            {{-- Denominations --}}
            @include('livewire.pos.partials.coins')

        </div>

    </div>
</div>

@include('livewire.pos.partials.scripts.shortcuts')
@include('livewire.pos.partials.scripts.general')
@include('livewire.pos.partials.scripts.scan')
@include('livewire.pos.partials.scripts.events')



<script src="{{ asset('js/keypress.js') }}"></script>
<script src="{{ asset('js/onscan.js') }}"></script>
