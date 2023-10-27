<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <div class="my-4">
                            <button wire:click="create">Add Image</button>
                        </div>
                        @if ($isOpen)
                            <div>
                                <div class="absolute inset-0 bg-black opacity-50"></div>
                                <div class="relative bg-gray-200 p-8 rounded shadow-lg w-1/2">
                                    <!-- Modal content goes here -->

                                    <h2 class="text-2xl font-bold mb-4">Create Post</h2>
                                    <form wire:submit="store">
                                        <div class="mb-4">
                                            <label for="title"
                                                class="block text-gray-700 font-bold mb-2">Title:</label>
                                            <input wire:model="title" type="text" id="title">
                                        </div>
                                        <div class="mb-4">
                                            <label for="image"
                                                class="block text-gray-700 font-bold mb-2">Image:</label>
                                            <input wire:model="image" type="file" id="title">
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit">Create
                                            </button>
                                            <button type="button" wire:click="closeModal">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </section>
                    @if (session()->has('success'))
                        <div
                            class="relative flex flex-col sm:flex-row sm:items-center bg-gray-200 dark:bg-green-700 shadow rounded-md py-5 pl-6 pr-8 sm:pr-6 mb-3 mt-3">
                            <div
                                class="flex flex-row items-center border-b sm:border-b-0 w-full sm:w-auto pb-4 sm:pb-0">
                                <div class="text-green-500" dark:text-gray-500>

                                </div>
                                <div class="text-sm font-medium ml-3">Success!.</div>
                            </div>
                            <div class="text-sm tracking-wide text-gray-500 dark:text-white mt-4 sm:mt-0 sm:ml-4">
                                {{ session('success') }}</div>
                            <div
                                class="absolute sm:relative sm:top-auto sm:right-auto ml-auto right-4 top-4 text-gray-400 hover:text-gray-800 cursor-pointer">


                            </div>
                        </div>
                    @endif

                    {{-- table starts --}}
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Image
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            @forelse ($posts as $post)
                                <tbody wire:key="{{ $post->id }}">
                                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $post->title }}
                                        </th>
                                        <td class="px-6 py-4 text-gray-900">
                                            <img src="{{ Storage::url('' . $post->image) }}" alt="{{ $post->title }}">
                                        </td>




                                        <td class="px-6 py-4 text-gray-900">
                                            <button class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="ml-2 mt-0 w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                </svg>
                                            </button>
                                            <button class="">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="ml-2 mt-0 w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            @empty
                                <p>No post found</p>
                            @endforelse
                        </table>

                        {{ $posts->links() }}
                    </div>
                    {{-- table ends --}}
                </div>
            </div>
        </div>
    </div>
</div>
