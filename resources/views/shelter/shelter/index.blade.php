@extends('layout.master')

@section('content')

<div class="row">
    <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Oporavilišta za divlje životinje</h6>
                        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                    </div>
                    <div>
                        <a href="{{ route("shelter.create") }}" class="btn btn-primary">Dodaj</a>
                    </div>
                </div>

                @if($msg = Session::get('msg'))
                <div class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NAZIV OPORAVILIŠTA</th>
                        <th>ADRESA OPORAVILIŠTA</th>
                        <th>EMAIL</th>
                        <th>TELEFON</th>
                        <th>ADMINISTRATOR</th>
                        <th>Ovlašteno</th>
                        <th>AKCIJA</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($shelters as $shelter)
                        <tr>
                            <td>{{ $shelter->id }}</td>
                            <td>{{ $shelter->name }}</td>                 
                            <td>{{ $shelter->address }}</td>
                            <td>{{ $shelter->email }}</td>
                            <td>{{ $shelter->telephone }}</td>
                            <td>{{ $shelter->users->first()->name ?? '' }}</td>
                            <td>
                                @foreach ($shelter->shelterTypes as $type)
                                    <button type="button" class="btn btn-{{ $type->id == 1 ? 'warning' : 'danger' }}" data-toggle="tooltip" data-placement="top" title="{{ $type->name }}">
                                        {{ $type->code }}
                                    </button>
                                @endforeach
                            </td>
                            <td class="d-flex justify-content-between">
                                <a href="{{ route('shelter.show', [$shelter->id]) }}" class="btn btn-info" href="#" role="button">Pregled</a>
                                <a class="btn btn-warning" href="{{ route("shelter.edit", $shelter) }}" role="button">Uredi</a>
                                <a onclick="return confirm('Are you sure?')">
                                    <form action="{{ route('shelter.destroy', ['shelter' => $shelter->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Obriši</button>
                                    </form>
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