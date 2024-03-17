<style>
    .otp-code {
        font-size: 35px;
        font-weight: bold;
        margin-top: 20px;
        letter-spacing: 10px;
        color: #282F3B;
    }
</style>
<x-mail::message>
    Hello {{ $name }},

    Your account with {{ config('app.name') }} as a {{ $role }} has been created.

    Please use the following :
    <p class="otp-code">{{ $password }}</p>


    as your one time password to login in the app

    If you dont have the app please contact us or download the app from the play store

    <x-mail::button url="https://play.google.com/store/apps/details?id=com.otp.otp" color="success" target="_blank" rel="noopener">
        Download YoProperty App
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>