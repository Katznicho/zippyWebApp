<x-mail::message>
    Hello {{ $user->name }},

    {{$message}}


    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>