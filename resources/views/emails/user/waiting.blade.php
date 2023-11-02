<x-mail::message>
# Bonjour {{ $user->name }},

Une place s'est libérée pour le cours du {{ $date->dateForHumans }}.
Vous avez été inscrit automatiquement

<x-mail::button :url="config('app.url')">
Voir les cours
</x-mail::button>

Bonne journée :)
</x-mail::message>
