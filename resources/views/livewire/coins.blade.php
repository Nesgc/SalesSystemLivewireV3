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
                            data-bs-target="#theModal">Add</a>
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
                                            data-bs-toggle="modal" data-bs-target="#theModal"
                                            wire:click="Edit({{ $denomination->id }})"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                            wire:confirm="Are you sure?" wire:click="Delete({{ $denomination->id }})"><i
                                                class="fa-solid fa-trash"></i></a>

                                        <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                            data-bs-toggle="modal" data-bs-target="#delete"
                                            wire:click="Delete2({{ $denomination->id }})"><i
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
        document.addEventListener('livewire:init', () => {
            Livewire.directive('confirm', ({
                el,
                directive,
                component,
                cleanup
            }) => {
                let content = directive.expression

                // The "directive" object gives you access to the parsed directive.
                // For example, here are its values for: wire:click.prevent="deletePost(1)"
                //
                // directive.raw = wire:click.prevent
                // directive.value = "click"
                // directive.modifiers = ['prevent']
                // directive.expression = "deletePost(1)"

                let onClick = e => {
                    if (!confirm(content)) {
                        e.preventDefault()
                        e.stopImmediatePropagation()
                    }
                }

                el.addEventListener('click', onClick, {
                    capture: true
                })

                // Register any cleanup code inside `cleanup()` in the case
                // where a Livewire component is removed from the DOM while
                // the page is still active.
                cleanup(() => {
                    el.removeEventListener('click', onClick)
                })
            })
        })
    </script>

    <script>
        document.addEventListener('livewire:init', () => {

            $(function() {
                $('.edit').click(function(e) {
                    e.preventDefault();
                    console.log(
                        'Edit button clicked!'
                    ); // Agregar mensaje de consola para verificar el evento click
                    $('#edit').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });

                $('.delete').click(function(e) {
                    e.preventDefault();
                    $('#delete').modal('show');
                    var id = $(this).data('id');
                    getRow(id);
                });
            });

            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'unidades_row.php',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#id').val(response.id);
                        $('#edit_economico').val(response.economico);
                        $('#edit_tipo').val(response.tipo);
                        $('#edit_operador').val(response.operador);
                        $('#del_id').val(response.id);
                        $('#del_unidades').html(response.economico);
                    }
                });
            }
        })
    </script>
</div>
