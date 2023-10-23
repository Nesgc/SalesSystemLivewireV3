<div class="row mt-3">
    <div class="col-sm-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-2">Denominaciones</h5>

            <div class="container">
                <div class="row">
                    @foreach ($denominations as $d)
                        <div class="col-sm-4 mt-2 text-center">
                            <button wire:click.prevent='ACash({{ $d->value }})'
                                class="d-grid col-12 mx-auto btn btn-dark btn-block den">
                                {{ $d->value > 0 ? '$' . number_format($d->value, 2, '.', '') : 'Exacto' }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">

                            <span class="btn d-flex align-items-center"
                                style="background: #3B3F5C; color:white">Efectivo F8</span>

                            <input type="number" id="cash" wire:model='efectivo' wire:keydown.enter='saveSale'
                                class="form-cotrol text-center" value="{{ $efectivo }}">
                            <div class="input-group-append">
                                <span wire:click='$set("efectivo", 0)' class="input-group-text"
                                    style="background: #3B3F5C; color:white">
                                    <i class="fas fa-backspace fa-2x"></i></span>
                            </div>
                        </div>
                        <h4 class="text-muted">Cambio: ${{ number_format($change, 2) }}</h4>
                        <div class="row justify-content-between mt-5">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($total > 0)
                                    <button onclick="Confirm('', 'clearCart', 'Seguro de eliminar el carrito?')"
                                        class="btn btn-dark mtmobile">
                                        Cancelar F4
                                    </button>
                                @endif

                            </div>

                            <div class="col-sm-12 col-md-12 col-lg-6">
                                @if ($efectivo >= $total && $total > 0)
                                    <button wire:click.prevent='saveSale' class="btn btn-dark btn-md btn-block">Guardar
                                        F9</button>
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
