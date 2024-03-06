<x-mail::message>

Bonjour Mme/Mr {{ $prenom }}
Votre Code de verification est {{ $code }}.

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

{{-- Thanks,<br>
{{ config('app.name') }} --}}
</x-mail::message>
