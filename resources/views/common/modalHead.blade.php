<div wire:ignore.self id="theModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><b>{{ $componentName }}</b> |
                    {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}</h5>
                <h6 class="text-center text-warning" wire:loading>Porfavor Espera</h6>
            </div>
            <div class="modal-body">
