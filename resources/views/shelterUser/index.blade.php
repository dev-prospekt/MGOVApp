@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h6 class="card-title">Korisnici</h6>
                <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>

                <a href="{{ route('users.create') }}" class="btn btn-info mb-2">
                    Dodaj korisnika
                </a>

                @if($msg = Session::get('msg'))
                    <div class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ime i prezime</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody>
        
                        @foreach ($users as $user)
                        <tr>
                            <th>{{ $user->id }}</th>
                            <td>{{ $user->name_lastname  }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="d-flex">
                                <a class="btn btn-primary mr-2" href="{{ route('users.show', $user) }}" role="button">Info</a>
                                <a onclick="return confirm('Are you sure?')">
                                    <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>

@endsection