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

Thank you for signing up with {{ config('app.name') }}  as a {{ $user->role }}.

Please use the following code to verify your email:
    <p class="otp-code"> {{ $verificationCode }}</p>

 as a one time code.

Enter the code on the verification screen to complete your registration.
The code will expire in 10 minutes.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
