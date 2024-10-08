<div>
    <x-admin.breadcrumb :breadcrumb="$this->breadcrumb ?? ''" />

    <div class="wrapper mt-4">
        <form wire:submit="save">
            <div class="row">
                <div class="col-12 mb-3">
                    <x-admin.form.input-label value="Role Name" />
                    <select class="form-control" wire:model.live.debounce.250ms="form.role_id">
                        <option value="">Select Role</option>
                        @foreach($this->roles as $role)
                        <option value="{{ $role->id }}">{{ Str::title(Str::replace('-', ' ', $role->name)) }}</option>
                        @endforeach
                    </select>
                    <x-admin.form.input-error :messages="$errors->get('form.role_name')" />
                </div>
            </div>

            <div class="table-responsive position-relative p-0 rounded-4">
                <x-admin.overlay model="form.role_id, save" />

                <table class="mb-0 custom-table w-100">
                    <thead>
                        <tr class="border-bottom">
                            <th scope="col" class="small fw-semibold py-3 ps-3">#</th>
                            <th scope="col" class="small fw-semibold py-3">Permission</th>
                            <th scope="col" class="small fw-semibold py-3 text-center">View</th>
                            <th scope="col" class="small fw-semibold py-3 text-center">Create</th>
                            <th scope="col" class="small fw-semibold py-3 text-center">Update</th>
                            <th scope="col" class="small fw-semibold py-3 text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->permissions as $entity => $permission)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::replace('-', ' ', Str::title($entity)) }}</td>

                            <!-- View Permission -->
                            <td class="text-center">
                                @if($permission->contains('name', 'view:' . $entity))
                                <x-admin.form.input-field wire:model="form.permissions" class="form-check-input p-2" type="checkbox" id="remember-me" style="float: inherit; margin-left: 0; display: inline-flex;" value="view:{{ $entity }}" />
                                @else
                                <i class="fa-solid fa-times text-danger-emphasis"></i>
                                @endif
                            </td>

                            <!-- Create Permission -->
                            <td class="text-center">
                                @if($permission->contains('name', 'create:' . $entity))
                                <x-admin.form.input-field wire:model="form.permissions" class="form-check-input p-2" type="checkbox" id="remember-me" style="float: inherit; margin-left: 0; display: inline-flex;" value="create:{{ $entity }}" />
                                @else
                                <i class="fa-solid fa-times text-danger-emphasis"></i>
                                @endif
                            </td>

                            <!-- Update Permission -->
                            <td class="text-center">
                                @if($permission->contains('name', 'update:' . $entity))
                                <x-admin.form.input-field wire:model="form.permissions" class="form-check-input p-2" type="checkbox" id="remember-me" style="float: inherit; margin-left: 0; display: inline-flex;" value="update:{{ $entity }}" />
                                @else
                                <i class="fa-solid fa-times text-danger-emphasis"></i>
                                @endif
                            </td>

                            <!-- Delete Permission -->
                            <td class="text-center">
                                @if($permission->contains('name', 'delete:' . $entity))
                                <x-admin.form.input-field wire:model="form.permissions" class="form-check-input p-2" type="checkbox" id="remember-me" style="float: inherit; margin-left: 0; display: inline-flex;" value="delete:{{ $entity }}" />
                                @else
                                <i class="fa-solid fa-times text-danger-emphasis"></i>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <button type="submit" wire:target="save" wire:loading.attr="disabled" class="primary-btn px-3 py-2 mt-4 text-white mx-auto d-block small">Save <i class="fa-solid fa-save"></i></button>
        </form>
    </div>
</div>
