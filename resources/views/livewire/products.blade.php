<div>
    <div class="row sales layout-top-spacing">

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

                @include('common.searchbox')

                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-bordered striped mt-1">
                            <thead class="text-white" style="background: #3B3F5C;">
                                <tr>
                                    <th class="table-th text-white">Products</th>
                                    <th class="table-th text-white">Categories</th>
                                    <th class="table-th text-white">Barcode</th>
                                    <th class="table-th text-white">Price</th>
                                    <th class="table-th text-white">Stock</th>
                                    <th class="table-th text-white">Alerts</th>
                                    <th class="table-th text-white">Image</th>
                                    <th class="table-th text-white">Actions</th>


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <h6>{{ $product->name }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->category }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->barcode }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->price }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->stock }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $product->alerts }}</h6>
                                        </td>

                                        <td class="text-center"><span><img
                                                    src="{{ asset('storage/' . $product->image) }}" alt="example"
                                                    height="70" width="80" class="rounded"></span>
                                        </td>


                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                                wire:click.prevent="Edit({{ $product->id }})"><i
                                                    class="fa-solid fa-pen-to-square"></i></a>

                                            <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                                wire:click="delete({{ $product->id }})"><i
                                                    class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </table>
                        {{ $products->links() }}

                    </div>
                </div>
            </div>

        </div>
        @include('livewire.products.productForm')
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('product-added', msg => {
                $('#themodal').modal('hide');
                Swal.fire(
                    'Genial!',
                    `${msg}`,
                    'success'
                )
            });

            @this.on('product-updated', msg => {
                $('#themodal').modal('hide');
                //   noty(msg);
                Swal.fire(
                    'Genial!',
                    `${msg}`,
                    'success'
                )
            });

            @this.on('product-deleted', msg => {
                $('#themodal').modal('hide');
                Swal.fire(
                    ':(',
                    `${msg}`,
                    'danger'
                )
            });

            @this.on('hide-modal', msg => {
                $('#themodal').modal('hide');
            });

            @this.on('show-modal', msg => {
                $('#themodal').modal('show');
            });

            @this.on('hidden.bs.modal', msg => {
                $('.er').css('display', 'none');
            });
        });
    </script>



</div>
