<div>
    <x-admin.breadcrumb :breadcrumb="$this->breadcrumb??''" />

    <div class="wrapper mt-4">
        <div class="row px-3">
            <div class="table-search text-end mb-3">
                @can('create:admin', 'admin')
                <div class="float-start">
                    <a href="{{ route('admin.admins.create') }}" class="btn-sm btn primary-btn px-3 py-2 text-white small" wire:navigate>
                        Create Admin
                    </a>
                </div>
                @endcan

                <div>
                    <x-admin.search-box model="search" placeholder="Search Admin..." />
                </div>
            </div>
            <div class="table-responsive position-relative p-0 rounded-4">
                <x-admin.overlay model="search" />

                <table class="mb-0 custom-table w-100">
                    <thead>
                        <tr class="border-bottom">
                            <th scope="col" class="small fw-semibold py-3 ps-3">#</th>
                            <th scope="col" class="small fw-semibold py-3">Full Name</th>
                            <th scope="col" class="small fw-semibold py-3">Email</th>
                            <th scope="col" class="small fw-semibold py-3">Phone</th>
                            <th scope="col" class="small fw-semibold py-3">Role</th>
                            <th scope="col" class="small fw-semibold py-3">Status</th>
                            <th scope="col" class="small fw-semibold py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = $this->admins->firstItem();
                        @endphp
                        @forelse($this->admins as $admin)
                        <tr>
                            <td class="ps-3" scope="row">{{ $i++ }}</td>
                            <td class="small">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('assets/images/me.jpg') }}" width="40px" class="rounded-circle user-darg-none" alt="{{ $admin->full_name }}">
                                    {{ $admin->full_name }}
                                </div>
                            </td>
                            <td class="small">{{ $admin->email }}</td>
                            <td class="small">{{ $admin->phone }}</td>
                            <td class="small">
                                {!! $admin->roles->first()?->name ? Str::title(Str::replace('-', ' ', $admin->roles->first()?->name)):'<span class="text-danger-emphasis">No Role</span>' !!}
                            </td>
                            <td>
                                <span class="badge text-body {{ $admin->status == 'active'?'bg-success':'bg-danger' }} bg-opacity-10 small fw-semibold py-2 px-3 ">{{ Str::ucfirst($admin->status) }}</span>
                            </td>
                            <td>
                                @can('update:admin-role-permission', 'admin')
                                @if($admin->id != Auth::guard('admin')->id())
                                <x-admin.action-button href="{{ route('admin.admins.permissions', $admin->id) }}" class="bg-secondary-subtle text-secondary" data-bs-placement="top" title="User Role or Permissions">
                                    <i class="fa-solid fa-user-shield"></i>
                                </x-admin.action-button>
                                @endif
                                @endcan

                                @can('update:admin', 'admin')
                                <x-admin.action-button href="{{ $admin->id != Auth::guard('admin')->id()?route('admin.admins.edit', $admin->id):route('admin.profile') }}" class="bg-primary-subtle text-primary" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </x-admin.action-button>
                                @endcan

                                @can('delete:admin', 'admin')
                                @if($admin->id != Auth::guard('admin')->id())
                                <x-admin.delete-button class="p-2" :id="$admin->id" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </x-admin.delete-button>
                                @endif
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <x-admin.empty-table colspan="7" />
                        @endforelse
                    </tbody>
                </table>

                <x-admin.table-result :item="$this->admins" />
            </div>

            <x-admin.pagination :paginator="$this->admins" :scrollTo="false" />
        </div>
    </div>
</div>
