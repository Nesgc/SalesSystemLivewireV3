<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center">
                    <b>{{ $componentName }}</b>
                </h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-3">

                        <div class="col-sm-12">
                            <h6>Choose user</h6>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="0">All</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h6>Choose report type</h6>
                            <div class="form-group">
                                <select class="form-control">
                                    <option value="0">Today sales</option>
                                    <option value="1">Sales by date</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-2">
                            <h6>From date</h6>
                            <div class="form-group">
                                <input type="text" wire:model='dateFrom' class="form-control flatpickr"
                                    placeholder="Click to choose">
                            </div>
                        </div>

                        <div class="col-sm-12 mt-2">
                            <h6>To date</h6>
                            <div class="form-group">
                                <input type="text" wire:model='dateTo' class="form-control flatpickr"
                                    placeholder="Click to choose">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <button wire:click='$refresh' class="btn btn-darl btn-block">
                                Consult
                            </button>

                            <a class="btn btn-dark btn-block {{ count($data) > 1 ? 'disabled' : '' }}"
                                href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Create
                                PDF</a>

                            <a class="btn btn-dark btn-block {{ count($data) > 1 ? 'disabled' : '' }}"
                                href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Export
                                to excel</a>

                        </div>

                    </div>

                    <div class="col-sm-12 col-md-9">
                        {{-- Table --}}
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mt-1">
                                <thead class="text-white" style="background: #3B3F5C;">
                                    <tr>
                                        <th class="table-th text-white text-center">Folio</th>
                                        <th class="table-th text-white text-center">Total</th>
                                        <th class="table-th text-white text-center">Items</th>
                                        <th class="table-th text-white text-center">Status</th>
                                        <th class="table-th text-white text-center">User</th>
                                        <th class="table-th text-white text-center">Date</th>
                                        <th class="table-th text-white text-center" width="50px"></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($data) < 1)
                                        <tr>
                                            <td colspan="7">
                                                <p class="text-center">No results.</p>
                                            </td>
                                        </tr>
                                    @endif


                                    @foreach ($data as $d)
                                        <tr>
                                            <td class="text-center">
                                                <h6>{{ $d->id }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ number_format($d->total, 2) }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->items }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->status }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ $d->user }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}
                                                </h6>
                                            </td>
                                            <td class="text-center" width="50px">
                                                <button class="btn btn-dark btn-sm">
                                                    <i class="fas fa-list"></i>
                                                </button>
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
    </div>

    @include('livewire.reports.sales-detail')
</div>
