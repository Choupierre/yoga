@component('mail::message')
# Bonjour {{ $user->name }},

Vous avez été ajouté à la classe de piccolo du CRR Boulogne par {{ Auth::user()->name }}.<br>
Pour créer votre mot de passe, cliquez sur "Forgot your password".

@component('mail::button', ['url' => config('app.url')])
Voir les cours
@endcomponent

Bonne journée :)
@endcomponent
