<div class="row justify-content-center align-items-center">
    <div class="col-lg-5">
        <div class="form-box bg-white p-5 rounded-5 shadow-sm">
            <div class="text-center mb-5">
                <x-admin.image :image="config('setting.site_general_logo')" alt="{{ config('setting.site_general_name') }}" height="60px" />
                <h5 class="fw-bold mt-3">{{ __('Forgot your password?')  }}</h5>
                <div class="mt-3 text-muted">
                    {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>
            </div>
            <form wire:submit="sendPasswordResetLink" class="mb-3">
                <div class="mb-4">
                    <div class="form-field position-relative">
                        <i class="prefix-icon fa-regular fa-envelope position-absolute"></i>
                        <x-admin.form.input-label value="{{ __('Email address') }}" />
                        <x-admin.form.input-field wire:model="form.email" placeholder="example@gmail.com" autofocus autocomplete="username" />
                    </div>
                    <x-admin.form.input-error :messages="$errors->get('form.email')" class="mt-2" />
                </div>

                <div class="text-center">
                    <button type="submit" class="primary-btn px-5 fw-bold py-2 text-white">
                        <i class="fa-solid fa-right-to-bracket text-white me-1 fs-6"></i> {{ __('Email Password Reset Link') }}
                        <div class="ps-2 d-inline-block">
                            <i class="fas fa-spinner fa-spin" wire:loading wire:target="sendPasswordResetLink"></i>
                        </div>
                    </button>
                </div>

                <div class="d-flex justify-content-center mt-5">
                    <a class="small" href="{{ route('admin.login') }}" wire:navigate>{{ __('Back to Login') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
