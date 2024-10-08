<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Admins;

use App\Models\Admin;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

#[Title('Admins')]
#[Layout('layouts.admin.app')]
class ShowAdmins extends Component
{
    use WithPagination;

    public $search = '';
    
    private string $guardName = 'admin'; // Guard name

    public function mount()
    {
        $this->authorize('view:admin', Auth::guard($this->guardName)->user());
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    #[On('delete')]
    public function deleteAdmin($id): void
    {
        $this->authorize('delete:admin', Auth::guard($this->guardName)->user());

        $admin = Admin::query()->findOrFail($id);

        if ($admin->id === Auth::guard($this->guardName)->id()) {
            $this->dispatch('swal:alert', [
                'title' => 'Failed',
                'text' => 'You cannot delete yourself',
                'icon' => 'error',
            ]);

            return;
        }

        $admin->delete();

        $this->dispatch('swal:alert', [
            'title' => 'Admin Deleted',
            'text' => 'Admin has been deleted successfully',
            'icon' => 'success',
            'timer' => 2000,
            'bar' => true,
        ]);

    }

    #[Computed]
    public function admins()
    {
        return Admin::with('roles')
            ->when($this->search, function ($query): void {
                $query->where(function ($q): void {
                    $q->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone', 'like', '%'.$this->search.'%')
                        ->orWhere('address', 'like', '%'.$this->search.'%')

                        ->orWhereHas('roles', function ($roleQuery): void {
                            $roleQuery->where('name', 'like', '%'.$this->search.'%');
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    #[Computed]
    public function breadcrumb(): array
    {
        return [
            'Dashboard' => route('admin.dashboard'),
            'Admins' => route('admin.admins.index'),
        ];
    }

    public function render()
    {
        return view('livewire.admin.admins.show-admins');
    }
}
