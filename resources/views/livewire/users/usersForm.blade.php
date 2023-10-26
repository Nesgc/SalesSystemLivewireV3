<div wire:ignore.self id="themodal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white"><b>{{ $componentName }}</b> |
                    {{ $selected_id > 0 ? 'Edit' : 'Create' }}</h5>
                <h6 class="text-center text-warning" wire:loading>Please wait...</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-8">


                        <div class="form-group">
                            <label>Name</label>

                            <input type="text" wire:model.lazy='name' class="form-control" placeholder="name"
                                aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        @error('name')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="col-sm-12 col-md-4">


                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" wire:model.lazy='email' class="form-control"
                                placeholder="Ej: nesgc@gmail.com" aria-label="Username" aria-describedby="basic-addon1">

                        </div>

                        @error('email')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-4 mt-3">

                        <div class="form-group">
                            <label for="">phone</label>

                            <input type="text" wire:model.lazy='phone' class="form-control"
                                placeholder="Example 8332021323" maxlenght="10" aria-label="Username"
                                aria-describedby="basic-addon1">
                        </div>

                        @error('phone')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-4 mt-3">

                        <div class="form-group">
                            <label for="">Password</label>

                            <input type="text" wire:model.lazy='password' class="form-control">
                        </div>

                        @error('password')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-sm-12 col-md-6 mt-3">
                        <div class="form-group">
                            <label>Asignar Role</label>
                            <select wire:model.lazy="profile" class="form-control">
                                <option value="Elegir" selected>Elegir</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" selected>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('profile')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-6 mt-3">
                        <div class="form-group">
                            <label for="">status</label>
                            <select class="form-select" wire:model="status">
                                <option value="Elegir" selected disabled>Choose status...</option>
                                <option value="ACTIVE">ACTIVE</option>
                                <option value="LOCKED">LOCKED</option>

                            </select>
                            @error('status')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-sm-12 col-md-12 mt-3">


                        <div class="col-sm-12 mt-1">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Image</label>
                                <input class="form-control" type="file" wire:model="tempImage" id="formFile">
                            </div>


                            @if ($selected_id > 0 && !$tempImage)
                                <img src="{{ asset('storage/' . $image) }}" alt="example" height="70"
                                    width="80" class="rounded">
                            @elseif($tempImage)
                                <img height="270" width="280" src="{{ $tempImage->temporaryUrl() }}">
                            @endif




                            @error('image')
                                <span class="error">{{ $message }}</span>
                            @enderror


                        </div>






                        @error('image')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror

                    </div>
                </div>


                @include('common.modalzFooter')
