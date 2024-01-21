<x-mail::message>
    Hello {{ $user->name }},

    {{$body}}



    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>