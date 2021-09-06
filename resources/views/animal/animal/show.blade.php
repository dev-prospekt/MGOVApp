@extends('layout.master')

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">Podatci</h6>

                @if($msg = Session::get('msg'))
                <div class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                <table class="table" id="animal-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NAZIV</th>
                        <th>LATINSKI NAZIV</th>
                        <th>KATEGORIJA</th>
                        <th>LOKACIJA</th>
                        <th>SPOL</th>
                        <th>VELIČINA</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($animal as $anim)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $anim->animal->name }}</td>
                                <td>{{ $anim->animal->latin_name }}</td>
                                <td>{{ $anim->animal->animalCategory->name }}</td>
                                <td>{{ $anim->location }}</td>
                                <td>{{ $anim->animal_gender }}</td>
                                <td>{{ $anim->animal_size }}</td>
                                <td>
                                    <a href="{{ route('animal.edit', $anim) }}" class="btn btn-info">
                                        Uredi
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

@endsection