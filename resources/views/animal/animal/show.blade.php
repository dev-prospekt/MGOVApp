@extends('layout.master')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">Podatci</h6>

                <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NAZIV</th>
                        <th>LATINSKI NAZIV</th>
                        <th>ŠIFRA</th>
                        <th>OPORAVILIŠTE</th>
                        <th>KATEGORIJA</th>
                        <th>LOKACIJA</th>
                        <th>SPOL</th>
                        <th>VELIČINA</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($animal->animalAttributes as $anim)
                        <tr>
                            <td>{{ $animal->id }}</td>
                            <td>{{ $animal->name }}</td>                 
                            <td>{{ $animal->latin_name }}</td>
                            <td>{{ $animal->sku }}</td>
                            <td><a href="/shelter/{{ $animal->shelter->id }}">{{ $animal->shelter->name }}</a></td>
                            <td>{{ $animal->animalCategory->name }}</td>
                            <td>{{ $anim->animal_location ?? '' }}</td>
                            <td>{{ $anim->animal_gender ?? '' }}</td>
                            <td>{{ $anim->animal_size ?? '' }}</td>
                        </tr>
                        @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

@endsection