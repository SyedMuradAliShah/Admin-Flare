<div class="content-header d-flex justify-content-between justify-content-lg-end align-items-center p-3 m-3">
    <button class="toggle-button" id="toggle-button">
        <i class="fa-solid fa-bars"></i>
    </button>
    <div class="d-flex align-items-center gap-4">
        <x-admin.darkmode-switch />
        <div class="notifications">
            <div class="dropdown">
                <button class="dropdown-toggle p-0 border-0 position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="badge position-absolute">25+</div>
                    <x-admin.icons.bell />
                </button>
                <ul class="dropdown-menu position-absolute p-0 overflow-hidden border-1 shadow-sm">
                    <li>
                        <a class="dropdown-item py-3" href="#">
                            <p class="mb-0 small fw-bold">Lorem ipsum dolor sit...</p>
                            <p class="small mb-0">
                                A magnam illo maxime error animi est..
                            </p>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-3" href="#">
                            <p class="mb-0 small fw-bold">Lorem ipsum dolor sit...</p>
                            <p class="small mb-0">
                                A magnam illo maxime error animi est..
                            </p>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item py-3" href="#">
                            <p class="mb-0 small fw-bold">Lorem ipsum dolor sit...</p>
                            <p class="small mb-0">
                                A magnam illo maxime error animi est..
                            </p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="profile">
            <div class="dropdown">
                <button class="dropdown-toggle p-0 border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <x-admin.icons.user />
                </button>
                <ul class="dropdown-menu position-absolute shadow-sm">
                    @if (Route::has('admin.profile'))
                    <li>
                        <a href="{{ route('admin.profile') }}" wire:navigate class="dropdown-item mb-2">
                            <i class="fa-regular fa-user"></i>
                            Profile
                        </a>
                    </li>
                    @endif
                    <li>
                        <a class="dropdown-item mb-2" href="#"><i class="fa-solid fa-gear"></i> Settings</a>
                    </li>
                    <li>
                        <a type="button" wire:click="logout" class="dropdown-item">
                            <i class="fa-solid fa-power-off"></i> {{ __('Log Out') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
