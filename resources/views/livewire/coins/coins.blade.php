<div class="row sales layout-top-spacing mt-4">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="btn btn-dark" wire:click="create"
                            data-bs-target="#themodal">Add</a>
                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center mb-3">
                <input type="text" wire:model.live="searchengine" class="form-control" placeholder="Search...">

            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table-bordered table striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C;">
                            <tr>
                                <th class="table-th fs-5 text-white">Value</th>
                                <th class="table-th fs-5 text-white">Type</th>


                                <th class="table-th fs-5 text-white">Image</th>
                                <th class="table-th fs-5 text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($denominations as $denomination)
                                <tr>
                                    <td>
                                        <h6>${{ $denomination->value }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $denomination->type }}</h6>
                                    </td>

                                    <td class="text-center"><span><img
                                                src="{{ asset('storage/' . $denomination->image) }}" alt="example"
                                                height="70" width="80" class="rounded"></span>
                                    </td>


                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            wire:click="Edit({{ $denomination->id }})"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                            wire:click="delete({{ $denomination->id }})"><i
                                                class="fa-solid fa-trash"></i></a>




                                        {{-- {{ $category->image }} --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $denominations->links() }}

                </div>

            </div>
        </div>
    </div>
    @include('livewire.coins.coinsForm')
    @include('livewire.coins.coinsDel')



    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('denomination-added', msg => {
                $('#themodal').modal('hide');
                noty(msg);
            })
            @this.on('denomination-updated', msg => {
                $('#themodal').modal('hide');
                //   noty(msg);
                Swal.fire(
                    'Genial!',
                    `${msg}`,
                    'success'
                )
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
