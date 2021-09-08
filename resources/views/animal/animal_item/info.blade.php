@extends('layout.master')

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <div>
            <a href="/shelter/{{ $animalItems->shelter_id }}" class="btn btn-primary">
                <i data-feather="left" data-toggle="tooltip" title="Connect"></i>
                Natrag
            </a>
        </div>
    </ol>
</nav>

    {{ $animalItems }}

@endsection