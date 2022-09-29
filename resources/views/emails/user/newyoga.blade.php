@component('mail::message')
# Bonjour {{ $user->name }},

Vous avez été ajouté aux membres des cours de yoga par {{ Auth::user()->name }}.
Pour créer votre mot de passe, cliquez sur "Forgot your password".

@component('mail::button', ['url' => config('app.url')])
Voir les cours
@endcomponent

Bonne journée :)
@endcomponent
