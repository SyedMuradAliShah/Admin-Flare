<?php

declare(strict_types=1);

namespace App\View\Components\Admin;

use Closure;
use Override;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class Sidebar extends Component
{
    /**
     * @var array<int, array{
     *     label: string,
     *     route: string,
     *     icon: string,
     *     active: bool,
     *     children: array<int, array<string, mixed>>,
     *     permission: string
     * }>
     */
    public array $sidebar;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->sidebar = [
            [
                'label' => 'Dashboard',
                'route' => route('admin.dashboard'), // Pass resolved route
                'icon' => '<i class="fa fa-home"></i>', // Raw HTML icon
                'active' => Route::is('admin.dashboard'),
                'children' => [],
                'permission' => '', // Example permission for dashboard
            ],
            // [
            //     'label'          => 'Admins',
            //     'icon_component' => 'admin.icons.table', // Blade component for icon
            //     'children'       => [
            //         [
            //             'label'      => 'Admins',
            //             'route'      => route('admin.admins.index'), // Resolved route
            //             'permission' => 'view:admins',
            //             'active'     => Route::is('admin.admins.index'),
            //         ],
            //         [
            //             'label'      => 'Roles',
            //             'route'      => route('admin.roles.index'), // Resolved route
            //             'permission' => 'view:roles',
            //             'active'     => Route::is('admin.roles.index'),
            //         ],
            //         [
            //             'label'      => 'Permissions',
            //             'route'      => route('admin.permissions.index'), // Resolved route
            //             'permission' => 'view:permissions',
            //             'active'     => Route::is('admin.permissions.index'),
            //         ],
            //     ],
            //     'permissions'    => [ 'view:admins', 'view:roles', 'view:permissions' ], // Multiple permissions
            //     'active'         => Route::is('admin.admins.index') || Route::is('admin.roles.index') || Route::is('admin.permissions.index'), // Active state for dropdown
            // ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    #[Override]
    public function render(): View|Closure|string
    {
        return view('components.admin.sidebar', ['sidebar' => $this->sidebar]);
    }
}
