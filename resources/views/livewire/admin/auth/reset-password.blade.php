<div class="row justify-content-center align-items-center">
    <div class="col-lg-5">
        <div class="form-box bg-white p-5 rounded-5 shadow-sm">
            <div class="text-center mb-5">
                <x-admin.image :image="config('setting.site_general_logo')" alt="{{ config('setting.site_general_name') }}" height="60px" />
                <h5 class="fw-bold mt-3">{{ __('Set new password') }}</h5>
            </div>
            <div class="mt-5 mx-auto w-100" style="max-width: 400px;">
                <form wire:submit="resetPassword" class="mb-3">

                    <div class="mb-4">
                        <div class="form-field position-relative">
                            <i class="prefix-icon fa-solid fa-lock position-absolute"></i>
                            <x-admin.form.input-label value="{{ __('Password') }}" />
                            <x-admin.form.input-field wire:model="form.password" type="password" placeholder="Enter new password" autocomplete="new-password" />
    
                            <div class="postfix-icon position-absolute" data-password>
                                <i class="fa-solid fa-eye" style="cursor: pointer"></i>
                                <i class="fa-solid fa-eye-slash" style="display: none; cursor: pointer"></i>
                            </div>
                        </div>
                        <x-admin.form.input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <div class="form-field position-relative">
                            <i class="prefix-icon fa-solid fa-lock position-absolute"></i>
                            <x-admin.form.input-label value="{{ __('Confirm Password') }}" />
                            <x-admin.form.input-field wire:model="form.password_confirmation" type="password" placeholder="Enter new password again" autocomplete="new-password" />
    
                            <div class="postfix-icon position-absolute" data-password>
                                <i class="fa-solid fa-eye" style="cursor: pointer"></i>
                                <i class="fa-solid fa-eye-slash" style="display: none; cursor: pointer"></i>
                            </div>
                        </div>
                        <x-admin.form.input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <div class="mt-2 mb-3">
                        <x-admin.form.input-error :messages="$errors->get('form.error')" class="mt-2" />
                    </div>

                    <div class="text-center">
                        <button type="submit" class="primary-btn px-5 fw-bold py-2 text-white">
                            <i class="fa-solid fa-right-to-bracket text-white me-1 fs-6"></i> {{ __('Reset Password') }}
                            <div class="ps-2 d-inline-block">
                                <i class="fas fa-spinner fa-spin" wire:loading wire:target="resetPassword"></i>
                            </div>
                        </button>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a class="small" href="{{ route('admin.login') }}" wire:navigate>{{ __('Back to Login') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
