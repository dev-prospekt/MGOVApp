@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Oporavilišta za divlje životinje</h6>
                        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                    </div>
                    <div>
                        <a href="{{ route("user.create") }}" class="btn btn-primary">Dodaj</a>
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
                        <th>IME</th>
                        <th>EMAIL</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="d-flex justify-content-between">
                            <a href="#" class="btn btn-info" href="#" role="button">Pregled</a>
                            <a class="btn btn-warning" href="{{ route("user.edit", $user) }}" role="button">Uredi</a>
                            <a onclick="return confirm('Are you sure?')">
                                <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="POST">
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
</div>

@endsection