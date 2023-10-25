<div class="row sales layout-top-spacing mt-4">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>


                        <button href="javascript:void(0)" type="button" data-bs-toggle="modal" class="btn btn-dark btn-lg"
                            wire:click="create" data-bs-target="#themodal">Add</button>

                    </li>
                </ul>
            </div>
            <div class="d-flex align-items-center mb-3">
                <input type="text" wire:model.live="searchengine" class="form-control" placeholder="Search...">

            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white" style="background: #3B3F5C;">
                            <tr>
                                <th class="table-th text-white text-center">Name</th>
                                <th class="table-th text-white text-center">Image</th>
                                <th class="table-th text-white text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $category->name }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="example"
                                            height="70" width="80" class="rounded">
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            wire:click="Edit({{ $category->id }})">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @if ($category->products->count() < 1)
                                            <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                                wire:click="Delete({{ $category->id }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $categories->links() }}

                </div>

            </div>
        </div>
    </div>
    @include('livewire.category.categoriesForm')


    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('category-added', msg => {
                $('#themodal').modal('hide');

            })
            @this.on('category-updated', msg => {
                $('#themodal').modal('hide');
                //   noty(msg);

            })
            @this.on('category-deleted', msg => {

            })
            //  @this.on('hide-modal', msg => {
            //       $('#themodal').modal('hide');
            //   })
            @this.on('show-modal', msg => {
                $('#themodal').modal('show');
            })
            //  @this.on('hidden.bs.modal', msg => {
            //       $('.er').css('display', 'none');
            //   })
        });
    </script>

</div>
