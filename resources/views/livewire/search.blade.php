<div class="d-flex align-items-center ">
    <input type="text" wire:keydown.enter.prevent="$dispatch('scan-code', $('#code').val())"
        class="form-control search-form-control text-white search  ml-lg-auto" placeholder="Search...">

</div>


<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('scan-code', action => {
            $('#code').val('')
        })

    });
</script>
