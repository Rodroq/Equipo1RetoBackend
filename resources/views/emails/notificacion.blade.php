<x-mail::message>
    # Buenas, {{ $usuario->name }}
    ## Le deseabamos informar de nuevas notificaciones

    {{ $mensaje }}

    <x-mail::button :url="''">
        Ir a la web
    </x-mail::button>

    Coordiales saludos desde nuestro equipo<br>
    Y gracias por confiar en nosotros,<br>
    {{ config('app.name') }}

</x-mail::message>
