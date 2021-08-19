@extends('layout.master')

@section('content')


    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h6 class="card-title">Korisnik</h6>
                <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Ime i prezime</th>
                            <th>Email</th>
                            <th>Oporavilište</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>{{ $user->id }}</th>
                                <td>{{ $user->name_lastname  }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->shelter->name }}</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('users.edit', $user) }}" role="button">Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>

@endsection