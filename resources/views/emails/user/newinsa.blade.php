@component('mail::message')
# Bonjour {{ $user->name }},

Vous avez été ajouté aux membres des cours de flûte de l'Insa par {{ Auth::user()->name }}.<br>
Pour créer votre mot de passe, cliquez sur "Forgot your password".

@component('mail::button', ['url' => config('app.url')])
Voir les cours
@endcomponent

Bonne journée :)
@endcomponent
