<nav class="sidebar" id="sidebar">
    <button class="close-button" id="close-button">
        <i class="fa-regular fa-circle-xmark"></i>
    </button>
    <div class="sidebar-header mb-4 text-center">
        <x-admin.image :image="config('setting.site_general_logo')" alt="{{ config('setting.site_general_name') }}" height="60px" />
    </div>
    <ul class="sidebar-menu p-0">
        <li>
            <a href="{{ route('admin.dashboard') }}" wire:navigate class="d-flex align-items-center gap-2 {{ Route::is('admin.dashboard')?'active':'' }}">
                <x-admin.icons.dashboard />
                Dashboard
            </a>
        </li>

        @if (Route::has('admin.admins.index') || Route::has('admin.admins.roles.index'))
        @canany(['view:admin', 'view:admin-role-permission'], 'admin')
        <li class="dropdown {{ Route::is('admin.admins.*')?'open':'' }}">
            <a class="dropdown-toggle d-flex align-items-center gap-2 {{ Route::is('admin.admins.*')?'active':'' }}">
                <x-admin.icons.user />
                Admins
                <i class="fa fa-chevron-down ms-auto"></i>
            </a>
            <ul class="dropdown-menu p-0 border-0 bg-transparent">
                @can('view:admin', 'admin')
                <li><a href="{{ route('admin.admins.index') }}" wire:navigate>Admins</a></li>
                @endcan
                @can('view:admin-role-permission', 'admin')
                <li><a href="{{ route('admin.admins.roles.index') }}" wire:navigate>Roles & Permissions</a></li>
                @endcan
            </ul>
        </li>
        @endcanany
        @endif
        {{-- <li class="dropdown">
            <a class="dropdown-toggle d-flex align-items-center gap-2">
                <x-admin.icons.message />
                Emails
                <i class="fa fa-chevron-down ms-auto"></i>
            </a>
            <ul class="dropdown-menu p-0 border-0 bg-transparent rounded-0">
                <li><a href="./inbox.html">Inbox</a></li>
                <li><a href="./sent.html">Sent Emails</a></li>
            </ul>
        </li>
        <li>
            <a href="" class="d-flex align-items-center gap-2">
                <x-admin.icons.ticket />
                Support Tickets
            </a>
        </li> --}}

        @if (Route::has('admin.settings.index'))
        @can('view:settings', 'admin')
        <li>
            <a href="{{ route('admin.settings.index') }}" class="d-flex align-items-center gap-2" wire:navigate>
                <i class="fa-solid fa-cog fs-5"></i>
                Settings
            </a>
        </li>
        @endcan
        @endif
    </ul>
</nav>
