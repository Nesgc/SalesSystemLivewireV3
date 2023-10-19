<div class="search-animated toggle-search">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
        class="feather feather-search">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
    </svg>
    <form class="form-inline search-full form-inline search" role="search">
        <div class="search-bar">
            <input type="text" class="form-control search-form-control  ml-lg-auto"
                wire:keydown.enter.prevent="$dispatch('scan-code', $('#code').val())" placeholder="Search...">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x search-close">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>
    </form>

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('scan-code', action => {
                $('#code').val('')
            })

        });
    </script>
</div>
