<div>
    <x-admin.breadcrumb :breadcrumb="$this->breadcrumb" />

    <div class="wrapper mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="genral-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">General</button>
                        <button class="nav-link" id="social-links-tab" data-bs-toggle="tab" data-bs-target="#social-links" type="button" role="tab" aria-controls="social-links" aria-selected="false">Social Links</button>
                        <button class="nav-link" id="other-tab" data-bs-toggle="tab" data-bs-target="#other" type="button" role="tab" aria-controls="other" aria-selected="false">Other</button>
                    </div>
                </nav>
                <div class="tab-content py-3" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="row justify-content-center">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 col-sm-6">
                                        <div class="fs-5 fw-semibold text-center mb-2">Site Logo</div>
                                        <form wire:submit="saveLogo">
                                            <div class="text-center">
                                                <x-admin.image-upload-view :model-var="$logo" :current-image="$this->settings->logo" model-name="logo" form-name="saveLogo" height="80px" width="200px" :is-rounded="false" />
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="fs-5 fw-semibold text-center mb-2">Site Favicon</div>
                                        <form wire:submit="saveFavicon">
                                            <div class="text-center">
                                                <x-admin.image-upload-view :model-var="$favicon" :current-image="$this->settings->favicon" model-name="favicon" form-name="saveFavicon" height="100px" width="100px" :is-rounded="false" />
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <form wire:submit="save">
                                        <div class="row justify-content-evenly">
                                            @foreach($this->settings->general as $setting)
                                            @if(Str::contains($setting->key, 'textarea'))
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <x-admin.form.input-label :value="Str::title(Str::replace('_general_textarea_',' ',$setting->key))" />
                                                    <x-admin.form.textarea-field wire:model="form.key.{{ $setting->key }}" />
                                                    <x-admin.form.input-error :messages="$errors->get('form.key.'.$setting->key)" />
                                                </div>
                                            </div>
                                            @else
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <x-admin.form.input-label :value="Str::title(Str::replace('_general_',' ',$setting->key))" />
                                                    <x-admin.form.input-field wire:model="form.key.{{ $setting->key }}" />
                                                    <x-admin.form.input-error :messages="$errors->get('form.key.'.$setting->key)" />
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>

                                        @can('update:settings', 'admin')
                                        <button type="submit" wire:target="save" wire:loading.attr="disabled" class="primary-btn px-3 py-2 mt-4 text-white mx-auto d-block small">Save <i class="fa-solid fa-save"></i></button>
                                        @endcan
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="social-links" role="tabpanel" aria-labelledby="social-links-tab">
                        <div class="row justify-content-center">
                            <div class="col-10">

                                <div class="row">
                                    <form wire:submit="save">
                                        <div class="row justify-content-evenly">
                                            @foreach($this->settings->socialLinks as $setting)
                                            <div class="col-12 col-md-6">
                                                <div class="mb-3">
                                                    <x-admin.form.input-label :value="Str::title(Str::replace('_social_',' ',$setting->key))" />
                                                    <x-admin.form.input-field wire:model="form.key.{{ $setting->key }}" />
                                                    <x-admin.form.input-error :messages="$errors->get('form.key.'.$setting->key)" />
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>

                                        @can('update:settings', 'admin')
                                        <button type="submit" wire:target="save" wire:loading.attr="disabled" class="primary-btn px-3 py-2 mt-4 text-white mx-auto d-block small">Save <i class="fa-solid fa-save"></i></button>
                                        @endcan
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">...</div>
                </div>
            </div>
        </div>
    </div>
</div>
