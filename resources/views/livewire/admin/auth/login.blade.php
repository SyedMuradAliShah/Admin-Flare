<div class="row justify-content-center align-items-center">
    <div class="col-lg-5">
        <div class="form-box bg-white p-5 rounded-5 shadow-sm">
            <div class="text-center mb-5">
                <x-admin.image :image="config('setting.site_general_logo')" alt="{{ config('setting.site_general_name') }}" height="60px" />
                <h5 class="fw-bold mt-3">{{ __('Sign in to your account') }}</h5>
            </div>
            <form wire:submit="login">
                <div class="mb-4">
                    <div class="form-field position-relative">
                        <i class="prefix-icon fa-regular fa-envelope position-absolute"></i>
                        <x-admin.form.input-label value="{{ __('Email address or username') }}" />
                        <x-admin.form.input-field wire:model="form.email" placeholder="example@gmail.com" autofocus autocomplete="username" />
                    </div>
                    <x-admin.form.input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <div class="form-field position-relative">
                        
                        @if (Route::has('admin.password.request'))
                        <a href="{{ route('admin.password.request') }}" wire:navigate class="small top-0 end-0  position-absolute">{{ __('Forgot Password?') }}</a>
                        @endif

                        <i class="prefix-icon fa-solid fa-lock position-absolute"></i>
                        <x-admin.form.input-label value="{{ __('Password') }}" />
                        <x-admin.form.input-field wire:model="form.password" type="password" placeholder="Enter password" autocomplete="current-password" />

                        <div class="postfix-icon position-absolute" data-password>
                            <i class="fa-solid fa-eye" style="cursor: pointer"></i>
                            <i class="fa-solid fa-eye-slash" style="display: none; cursor: pointer"></i>
                        </div>
                    </div>
                    <x-admin.form.input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>

                <div class="mb-5">
                    <div class="form-check ">
                        <x-admin.form.input-field wire:model="form.remember" class="form-check-input p-2" type="checkbox" id="remember-me" style="padding-left: 8px !important;"/>
                        <label class="form-check-label" for="remember-me">
                            {{ __('Remember me') }}
                        </label>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="primary-btn px-5 fw-bold py-2 text-white">
                        <i class="fa-solid fa-right-to-bracket text-white me-1 fs-6"></i> {{ __('Login') }}
                        <div class="ps-2 d-inline-block">
                            <i class="fas fa-spinner fa-spin" wire:loading wire:target="login"></i>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
