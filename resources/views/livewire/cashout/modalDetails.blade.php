<div wire:ignore.self id="themodal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><b>Sale Details</b> |
                </h5>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-bordered striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C;">
                            <tr>
                                <th class="table-th text-white">Products</th>
                                <th class="table-th text-white">Quantity</th>
                                <th class="table-th text-white">Price</th>
                                <th class="table-th text-white">Import</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($saledetail as $saled)
                                <tr>
                                    <td>
                                        <h6>{{ $saled->product }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $saled->quantity }}</h6>
                                    </td>
                                    <td>
                                        <h6>${{ number_format($saled->price, 2) }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ number_format($saled->quantity * $saled->price, 2) }}</h6>
                                    </td>




                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <td class="text-right">
                                <h6 class="text-info">Totals</h6>
                            </td>
                            <td class="text-center">
                                @if ($details)
                                    <h6 class="text-info">{{ $saled->sum('quantity') }}</h6>
                                @endif
                            </td>
                            @if ($details)
                                @php
                                    $mytotal = 0;
                                @endphp
                                @foreach ($details as $d)
                                    @php
                                        $mytotal += $d->quantity * $d->price;
                                    @endphp
                                @endforeach
                                <td></td>
                                <td class="text-center">
                                    <h6 class="text-info">${{ number_format($mytotal, 2) }}</h6>
                                </td>
                            @endif
                        </tfoot>
                    </table>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI" class="btn btn-dark close-btn text-info"
                    data-bs-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
