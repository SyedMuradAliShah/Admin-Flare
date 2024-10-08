<x-mail::message>
    # Reset Your Admin Password

    Click the button below to reset your admin password.

    <x-mail::button :url="$url">
        Reset Password
    </x-mail::button>

    Link not working? Copy and paste the URL below into your web browser:

    [{{ $url }}]({{ $url }})

    If you did not request a password reset, no further action is required.

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
