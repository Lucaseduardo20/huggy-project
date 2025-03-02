@component('mail::message')
    # Olá, {{ $client->name }}! 👋

    Seja bem-vindo(a) ao nosso serviço!

    Estamos felizes em ter você conosco. Se precisar de ajuda, entre em contato conosco.

    @component('mail::button', ['url' => 'https://huggy.app'])
        Acesse seu painel
    @endcomponent

    Atenciosamente,
    **Huggy**
@endcomponent
