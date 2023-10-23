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
                                <th class="table-th text-white">ID</th>
                                <th class="table-th text-white">Description</th>
                                <th class="table-th text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                                <tr>
                                    <td>
                                        <h6>{{ $permiso->id }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $permiso->name }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            wire:click.prevent="Edit({{ $permiso->id }})"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                            wire:click="delete({{ $permiso->id }})"><i
                                                class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $permisos->links() }}
                </div>
            </div>
        </div>

    </div>
    @include('livewire.permissions.permissionsForm')
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('permiso-added', Msg => {
            $('#themodal').modal('hide')
        })
        @this.on('permiso-updated', Msg => {
            $('#themodal').modal('hide')
        })
        @this.on('permiso-deleted', Msg => {})
        @this.on('permiso-exists', Msg => {})
        @this.on('permiso-error', Msg => {})
        @this.on('hide-modal', Msg => {
            $('#themodal').modal('hide')
        })
        @this.on('show-modal', Msg => {
            $('#themodal').modal('show')
        })

        @this.on('hidden.bs.modal', Msg => {
            $('.er').css('display', 'none');
        });

    })
</script>
