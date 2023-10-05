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
                                <th class="table-th text-white">Name</th>
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
                                    <td class="text-center"><span><img src="{{ asset('storage/' . $category->image) }}"
                                                alt="example" height="70" width="80" class="rounded"></span>
                                    </td>


                                    <td class="text-center">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" title="Edit"
                                            data-bs-toggle="modal" data-bs-target="#theModal"
                                            wire:click="Edit({{ $category->id }})"><i
                                                class="fa-solid fa-pen-to-square"></i></a>

                                        @if ($category->products->count() < 1)
                                            <a href="javascript:void(0)" class="btn btn-dark" title="Delete"
                                                wire:confirm="Are you sure?" wire:click="Delete({{ $category->id }})"><i
                                                    class="fa-solid fa-trash"></i></a>
                                        @endif

                                        {{-- {{ $category->image }} --}}
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
</div>
