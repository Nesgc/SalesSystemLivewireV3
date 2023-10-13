<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if ($total > 0)
                    <div class="table responsive tblscroll" style="max-height: 650px; overflow: hidden">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th width="10%"></th>
                                    <th class="table-th text-left text-white">Description</th>
                                    <th class="table-th text-center text-white">Price</th>
                                    <th width="13%" class="table-th text-center text-white"> CANT</th>
                                    <th class="table-th text-center text-white">Import</th>
                                    <th class="table-th text-center text-white">Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart as $item)
                                    <tr>
                                        <td class="text-center table-th">
                                            @if (count($item->attributes) > 0)
                                                <span>
                                                    <img src="{{ asset('storage/products/' . $item->attributes[0]) }}"
                                                        alt="Product image" height="90" width="90"
                                                        class="rounded">
                                                </span>
                                            @endif

                                        </td>
                                        <td>
                                            <h6>{{ $item->name }}</h6>
                                        </td>
                                        <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                        <td>
                                            <input type="number" id="r{{ $itm->id }}"
                                                wire:change="updateQty({{ $item->id }}, $('#r' +
                                            {{ $item->id }}).val())"
                                                style="font-size: 1rem!important" class="form-control text-center"
                                                value="{{ $item->quantity }}">
                                        </td>
                                        <td class="text-center">
                                            <h6>${{ number_format($item->price * $item->quantity, 2) }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                onclick="Confirm('{{ $item->id }}', 'removeItem', 'Confirmas eliminar el registro?')"
                                                class="btn btn-dark mbmobile"></button>
                                            <button wire:click.prevent="decreaseQty({{ $item->id }})"
                                                class="btn btn-dark mbmobile"> <i class="fas fa-minus"></i></button>
                                            <button wire:click.prevent="increaseQty({{ $item->id }})"
                                                class="btn btn-dark mbmobile"> <i class="fas fa-minus"></i></button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <h5 class="text-center text-muted">Agrega productos a la venta</h5>
                @endif
                <div wire:loading.inline wire:target="saveSale">
                    <h4 class="text-danger text-center">Guardando Venta...</h4>
                </div>
            </div>

        </div>
    </div>
</div>
