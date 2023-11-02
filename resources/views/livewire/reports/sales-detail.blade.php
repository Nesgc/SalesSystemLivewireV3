<div wire:ignore.self id="themodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Sale details #{{ $saleId }}
                        {{-- @foreach ($sales as $sale)
                        #{{ $sale->id }}
                        @endforeach --}}
                    </b>
                </h5>
                <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                    <img src="img/x.png" height="20" width="20" alt=""> </button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-center text-white">
                                    Invoice
                                </th>
                                <th class="table-th text-center text-white">
                                    Product
                                </th>
                                <th class="table-th text-center text-white">
                                    Price
                                </th>
                                <th class="table-th text-center text-white">
                                    Quantity
                                </th>
                                <th class="table-th text-center text-white">
                                    Import
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                {{-- dd($details) --}}
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $d->id }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>{{ $d->product }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>${{ number_format($d->price, 2) }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <h6>{{ $d->quantity }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>${{ number_format($d->quantity * $d->price, 2) }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3">
                                <h5 class="text-center font-weight-bold">Total</h5>
                            </td>
                            <td>
                                <h5 class="text-center">{{ $countDetails }}</h5>
                            </td>

                            <td class="text-center">
                                <h6 class="text-info"> {{ number_format($sumDetails, 2) }}</h6>
                            </td>

                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
