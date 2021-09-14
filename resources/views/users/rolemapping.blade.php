@extends('layout.master')

@section('content')

<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Role Mapping</h6>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                        <th>#</th>
                        <th>Ime</th>
                        <th>Email</th>
                        <th>Super Admin</th>
                        <th>Shelter Admin</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <form action="/roleMappingAdd" method="post">
                                @csrf

                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <td>
                                    <input type="checkbox" {{ $user->hasRole('Super-Admin') ? 'checked' : '' }} name="role_superadmin" style="accent-color: #be234a; width: 15px; height: 15px;">
                                </td>
                                <td>
                                    <input type="checkbox" {{ $user->hasRole('Shelter-Admin') ? 'checked' : '' }} name="role_shelteradmin" style="accent-color: #be234a; width: 15px; height: 15px;">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-sm btn-primary">Spremi</button>
                                </td>
                            </form>
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