<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>

            </div>

            <div class="widget-content">

                <div class="d-flex flex-row form-group mr-5 ">
                    <div>
                        <select wire:model="role" wire:change="togglePermission" class="form-control col-lg-8">
                            <option value="Elegir">Seleccione Rol</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <button type="button" wire:click.prevent="savePermissions()"
                        class="btn btn-dark mbmobile inblock mx-5 col-lg-2">
                        Sincronizar Permisos
                    </button>
                    <button type="button" wire:click.prevent="SyncAll()"
                        class="btn btn--dark mbmobile inblock mx-5 col-lg-2">
                        Asignar Todos
                    </button>
                    <button type="button" wire:click.prevent="delete()" class="btn btn--dark mbmobile mr-5 col-lg-2">
                        Revocar Todos
                    </button>
                </div>

                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table striped mt-1">
                                <thead class="text-white" style="background: #3b3f5c">
                                    <tr>
                                        <th class="table-th text-white text-center">ID</th>
                                        <th class="table-th text-white text-center">PERMISO</th>
                                        <th class="table-th text-white text-center">ROLES CON EL PERMISO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permisos as $permiso)
                                        <tr>
                                            <td>
                                                <h6 class="text-center">{{ $permiso->id }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <div class="n-check">
                                                    <label class="d-flex justify-content-center">
                                                        <input class="form-check-input mx-1" type="checkbox"
                                                            wire:click="toggleTempPermission('{{ $permiso->id }}')"
                                                            id="p{{ $permiso->id }}" value="{{ $permiso->id }}"
                                                            {{ $permiso->checked == 1 ? 'checked' : '' }}>

                                                        <span class=" new-control-indicator"></span>
                                                        <h6>{{ $permiso->name }}</h6>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <h6>{{ \App\Models\User::permission($permiso->name)->count() }}
                                                </h6>
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
        </div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('refreshPage', () => {
                location.reload();
            });
        });
    </script>

</div>
