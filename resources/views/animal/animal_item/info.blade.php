@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <div>
            <a href="/shelter/{{ $animalItems->shelter_id }}/animal/{{ $animalItems->shelter_code }}" class="btn btn-primary">
                <i data-feather="left" data-toggle="tooltip" title="Connect"></i>
                Natrag
            </a>
        </div>
    </ol>
</nav>

<div class="row">
    <div class="col-md-4 grid-margin">
        <div class="card rounded">
            <div class="card-body">
                <div class="mb-2">
                    <h6 class="card-title mb-0">Podatci Životinje</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 grid-margin">
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv: </label>
                            <p class="text-muted">{{ $animalItems->animal->name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Latinski naziv: </label>
                            <p class="text-muted">{{ $animalItems->animal->latin_name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Šifra oporavilišta:</label>
                            <p class="text-muted">{{ $animalItems->shelter_code }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dob:</label>
                            <p class="text-muted">{{ $animalItems->animal_dob }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Status:</label>
                            <p class="text-success">
                                @if ($animalItems->status == 1)
                                    Aktivan
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin">
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Veličina: </label>
                            <p class="text-muted">{{ $animalItems->animalSizeAttributes->name ?? '' }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Spol:</label>
                            <p class="text-muted">{{ $animalItems->animal_gender }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Lokacija:</label>
                            <p class="text-muted">{{ $animalItems->location }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Pronađena:</label>
                            <p class="text-muted">{{ $animalItems->date_found }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card rounded">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="card-title mb-0">Dokumenti životinje</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 grid-margin">
                        <p>Grupa</p>

                        @foreach ($mediaFiles as $fi)
                            <p>
                                <a class="text-muted mr-2" target="_blank" data-toggle="tooltip" data-placement="top" 
                                    href="{{ $fi->getUrl() }}">
                                    {{ $fi->name }}
                                </a>
                            </p>
                        @endforeach

                    </div>

                    <div class="col-md-6 grid-margin">
                        <p>Pojedinačni</p>

                        @if ($animalItemsMedia)
                            @foreach ($animalItemsMedia as $file)
                            <p id="findFile">
                                <a class="text-muted mr-2" target="_blank" data-toggle="tooltip" data-placement="top" 
                                    href="{{ $file->getUrl() }}">
                                    {{ $file->name }}
                                </a>
                            </p>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card rounded">
            <div class="card-body">
                <p>Stanje životinje u trenutku zaprimanja u oporavilište</p>
                    
                <div class="d-flex align-items-center flex-wrap">
                @foreach ($mediaStanjeZaprimanja as $fi)
                    <p class="m-2">
                        <img width="100px" src="{{ $fi->getUrl() }}" alt="{{ $fi->name }}">
                    </p>
                @endforeach
                </div>

                <p>Stanje u kojem je životinja pronađena</p>
                    
                <div class="d-flex align-items-center flex-wrap">
                @foreach ($mediaStanjePronadena as $fi)
                    <p class="m-2">
                        <img width="100px" src="{{ $fi->getUrl() }}" alt="{{ $fi->name }}">
                    </p>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('custom-scripts')
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush