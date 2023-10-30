<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center">
                    <b>Cashout</b>
                </h4>

            </div>
            <div class="widget-content">
                <div class="row">


                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>User</label>
                            <select class="form-select" wire:model='user_id' name="" id="">
                                <option value="0">Chooose</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label>Starting date</label>
                            <input type="date" wire:model.lazy='fromDate' class="form-control date">
                            @error('fromDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label>Ending date</label>
                            <input type="date" wire:model.lazy='toDate' class="form-control">
                            @error('toDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                        @if ($user_id > 0 && $fromDate != null && $toDate != null)
                            <button class="btn btn-dark mr-2" wire:click.prevent='Consult'>Consult</button>
                        @endif

                        @if ($total > 0)
                            <button class="btn-dark btn" wire:click.prevent='Print()'>Print</button>
                        @endif
                    </div>


                </div>
            </div>

            <div class="row mt-5">
                <div class="col-sm-12 col-md-4 mbmobile">
                    <div class="connect-sorting bg-dark">
                        <h5 class="text-white">
                            Total Sales: ${{ number_format($total, 2) }}
                        </h5>
                        <h5 class="text-white">Items: {{ $items }}</h5>
                    </div>
                </div>

                <div class="col-sm-12 col-md-8">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white">
                                <tr>
                                    <th class="table-th text-center text-white">Invoice</th>
                                    <th class="table-th text-center text-white">Total</th>
                                    <th class="table-th text-center text-white">Items</th>
                                    <th class="table-th text-center text-white">Date</th>
                                    <th class="table-th text-center text-white"></th>

                                </tr>
                            </thead>
                            <tbody>

                                @if ($total <= 0)
                                    <td colspan="5" style="color:#ff0000; font-size:20px;">No sales
                                        found within the selected date range.</td>
                                @endif
                                @foreach ($sale as $row)
                                    <tr>
                                        <td>
                                            <h6>${{ $row->id }}</h6>
                                        </td>
                                        <td>
                                            <h6>${{ number_format($row->total, 2) }}</h6>
                                        </td>
                                        <td>
                                            <h6>${{ $row->items }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $row->created_at }}</h6>
                                        </td>

                                        <td>
                                            <button wire:click.prevent='viewDetails({{ $row->id }})'
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-list"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cashout.modalDetails')

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('user-added', msg => {
                $('#themodal').modal('hide');
            })
            @this.on('user-updated', msg => {
                $('#themodal').modal('hide');
                //   noty(msg);

            })
            @this.on('denomiation-deleted', msg => {
                noty(msg);
            })
            //   window.livewire.on('hide-modal', msg => {
            //       $('#themodal').modal('hide');
            //   })
            @this.on('show-modal', msg => {
                $('#themodal').modal('show');
            })
            //   window.livewire.on('hidden.bs.modal', msg => {
            //       $('.er').css('display', 'none');
            //   })
        });
    </script>
</div>
