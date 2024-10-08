<div>
    <x-admin.breadcrumb :breadcrumb="$this->breadcrumb ?? ''" />

    <div class="wrapper mt-4">
        <div class="row px-3">
            <div class="table-search text-end mb-3">
                @can('create:admin-role-permission', 'admin')
                <div class="float-start">
                    <a href="{{ route('admin.admins.roles.create') }}" class="btn-sm btn primary-btn px-3 py-2 text-white small" wire:navigate>
                        Create Role
                    </a>
                </div>
                @endcan
                <x-admin.search-box model="search" placeholder="Search Role..." />
            </div>

            <div class="table-responsive position-relative p-0 rounded-4">
                <x-admin.overlay model="search" />

                @php $i = $this->roles->firstItem(); @endphp

                @forelse($this->roles as $role)
                <div class="d-flex align-items-center justify-content-between py-3 px-3 table-highlight border-bottom">
                    <!-- Role Name with Lock Icon if Protected -->
                    <div>
                        @if($role->protected)
                        <i class="fa-solid fa-lock text-danger-emphasis"></i>
                        @endif
                        <span class="small">{{ Str::replace('-', ' ', Str::title($role->name)) }}</span>
                        @if($role->protected)
                        <div class="small text-danger-emphasis">(It is a protected role, you can't delete it)</div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">

                        @can('update:admin-role-permission', 'admin')
                        <x-admin.action-button href="{{ route('admin.admins.roles.edit', $role->id) }}" class="bg-primary-subtle text-primary" title="Edit">
                            <i class="fa-regular fa-pen-to-square m-2"></i>
                        </x-admin.action-button>
                        @endcan

                        @if(!$role->protected)
                        <x-admin.delete-button :id="$role->id" title="Delete">
                            <i class="fa-regular fa-trash-can m-2"></i>
                        </x-admin.delete-button>
                        @endif
                    </div>
                </div>

                <!-- Permissions for Each Role -->
                <div class="mt-2 mb-4 px-3">

                    <table class="mb-0 custom-table w-100">
                        <thead>
                            <tr class="border-bottom">
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>View</th>
                                <th>Create</th>
                                <th>Update</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($this->permissions as $entity => $permission)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if(optional($permission->firstWhere('name', 'create:' . $entity))->protected && $role->protected)
                                    <i class="fa-solid fa-lock text-danger-emphasis"></i>
                                    @endif
                                    {{ Str::replace('-', ' ', Str::title($entity)) }}
                                </td>

                                <td>
                                    @if($permission->contains('name', 'view:' . $entity))
                                    @if($role->hasPermissionTo('view:' . $entity, 'admin'))
                                    <i class="fa-solid fa-check text-success-emphasis"></i>
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                </td>

                                <td>
                                    @if($permission->contains('name', 'create:' . $entity))
                                    @if($role->hasPermissionTo('create:' . $entity, 'admin'))
                                    <i class="fa-solid fa-check text-success-emphasis"></i>
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                </td>

                                <td>
                                    @if($permission->contains('name', 'update:' . $entity))
                                    @if($role->hasPermissionTo('update:' . $entity, 'admin'))
                                    <i class="fa-solid fa-check text-success-emphasis"></i>
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                </td>

                                <td>
                                    @if($permission->contains('name', 'delete:' . $entity))
                                    @if($role->hasPermissionTo('delete:' . $entity, 'admin'))
                                    <i class="fa-solid fa-check text-success-emphasis"></i>
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                    @else
                                    <i class="fa-solid fa-times text-danger-emphasis"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @empty
                <x-admin.empty-table />
                @endforelse

                <x-admin.table-result :item="$this->roles" />
            </div>

            <x-admin.pagination :paginator="$this->roles" :scrollTo="false" />
        </div>
    </div>
</div>
