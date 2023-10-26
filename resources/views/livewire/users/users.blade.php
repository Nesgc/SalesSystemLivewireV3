<div class="row sales layout-top-spacing mt-4">

    <div class="col-sm-12">

        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <li>
                        <button href="javascript:void(0)" data-bs-toggle="modal" class="btn btn-dark btn-lg"
                            wire:click="create" data-bs-target="#themodal">Add</button>
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
                                <th class="table-th fs-5 text-white">Name</th>
                                <th class="table-th fs-5 text-white">Email</th>

                                <th class="table-th fs-5 text-white">Phone</th>
                                <th class="table-th fs-5 text-white">Role</th>
                                <th class="table-th fs-5 text-white">Status</th>

                                <th class="table-th fs-5 text-white">Image</th>
                                <th class="table-th fs-5 text-white">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <h6>{{ $user->name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $user->email }}</h6>
                                    </td>

                                    <td>
                                        <h6>{{ $user->phone }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $user->profile }}</h6>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $user->status == 'ACTIVE' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $user->status }}</span>
                                    </td>

                                    <td class="">
                                        @if ($user->image != null)
                                            <span><img src="{{ asset('storage/' . $user->image) }}" alt="example"
                                                    height="70" width="80" class=" "></span>
                                        @endif

                                    </td>


                                    <td class="">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            wire:click="edit({{ $user->id }})"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                            wire:click="delete({{ $user->id }})"><i
                                                class="fa-solid fa-trash"></i></a>




                                        {{-- {{ $category->image }} --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $users->links() }}

                </div>

            </div>
        </div>
    </div>
    @include('livewire.users.usersForm')




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
