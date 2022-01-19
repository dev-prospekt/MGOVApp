@component('mail::message')
# MgovApp

Upisana je strogo zaštićena jedinka u oporavilište.

<div style="margin-bottom: 25px;">
    <div><strong>Naziv:</strong> {{ $data->animal->latin_name }}</div>
    <div><strong>Naziv oporavilišta:</strong> {{ $data->shelter->name }}</div>
    <div><strong>Evidencijski broj životinje:</strong> {{ $data->animal_code }}</div>
    <div><strong>Datum zaprimanja u oporavilište:</strong> {{ $data->dateRange->start_date->format('d.m.Y') }}</div>
</div>

@component('mail::button', ['url' => route('shelters.animal_groups.show', [$data->shelter->id, $data->animalGroup->id])])
Pregled
@endcomponent

@endcomponent

