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
Hello {{ $user->name }},

You have requested to reset your password. To verify
    that it's you, please use the following one-time
    verification code:

Please use the following code to verify your email:
    <p class="otp-code"> {{ $otp }}</p>

 as a one time code.

 Please enter this code on the password reset screen in your
    app to continue to reset your password.
    This code will expire in 5 minutes.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

