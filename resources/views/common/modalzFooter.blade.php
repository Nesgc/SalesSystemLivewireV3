</div>
<div class="modal-footer">
    <button type="button" wire:click.prevent="resetUI" class="btn btn-dark close-btn text-info"
        data-bs-dismiss="modal">Close</button>
    @if ($selected_id < 1)
        <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">Save</button>
    @else
        <button type="button" wire:click.prevent="Update()" class="btn btn-dark close-modal">Update</button>
    @endif

</div>
</div>
</div>
</div>
