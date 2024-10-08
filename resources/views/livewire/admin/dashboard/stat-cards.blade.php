<div class="row">
    <x-admin.stat-card class="box1" title="Total Admins" count="{{ Number::format($this->totalAdmins) }}" icon="fa-solid fa-user-tie" />
    
    <x-admin.stat-card class="box2" title="Total Roles" count="{{ Number::format($this->totalRoles) }}" icon="fa-solid fa-people-group" />

    <x-admin.stat-card class="box3" title="Total Permisisons" count="{{ Number::format($this->totalPermissions) }}" icon="fa-solid fa-address-card" />

    <x-admin.stat-card class="box4" />
</div>
