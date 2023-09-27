<div class="row sales layout-top-spacing mt-4">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <a href="javascript:void(0)" data-bs-toggle="modal" class="btn btn-dark"
                            data-bs-target="#theModal">Agregar</a>
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
                                <th class="table-th text-white">Description</th>
                                <th class="table-th text-white">Image</th>
                                <th class="table-th text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>
                                        <h6>{{ $category->name }}</h6>
                                    </td>
                                    <td class="text-center"><span><img
                                                src="{{ asset('storage/categories/' . $category->image) }}"
                                                alt="example" height="70" width="80" class="rounded"></span>
                                    </td>


                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#theModal"
                                            wire:click='Edit({{ $category->id }})'><i
                                                class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $category->id }}')"
                                            class="btn btn-dark" title="Delete"><i class="fa-solid fa-trash"></i></a>
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
    @include('livewire.category.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
    });
</script>
