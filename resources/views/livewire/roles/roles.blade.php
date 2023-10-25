<div class="row sales layout-top-spacing">

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
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        <h6>{{ $role->id }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $role->name }}</h6>
                                    </td>

                                    <td class="d-flex text-center">


                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile mx-1" title="Edit"
                                            wire:click.prevent="Edit({{ $role->id }})"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                            wire:click="delete({{ $role->id }})"><i
                                                class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $roles->links() }}
                </div>
            </div>
        </div>

    </div>
    @include('livewire.roles.form')
    @include('livewire.roles.formPerm')

</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        @this.on('role-added', Msg => {
            $('#themodal').modal('hide')
        })
        @this.on('role-updated', Msg => {
            $('#themodal').modal('hide')
        })
        @this.on('role-deleted', Msg => {})
        @this.on('role-exists', Msg => {})
        @this.on('role-error', Msg => {})
        @this.on('hide-modal', Msg => {
            $('#themodal').modal('hide')
        })
        @this.on('show-modal', Msg => {
            $('#themodal').modal('show')
        })
        @this.on('show-modals', Msg => {
            $('#themodals').modal('show')
        })
    });
</script>
