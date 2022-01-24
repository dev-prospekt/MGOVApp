@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />


<style>
    input[type='checkbox'] {
        accent-color: #be234a; 
        width: 15px; 
        height: 15px;
    }
</style>
@endpush

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Korisnici</h6>

                @if($msg = Session::get('role'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table" id="role">
                        <thead>
                            <tr>
                            <th>#</th>
                            <th>Ime</th>
                            <th>Email</th>
                            <th>Administrator</th>
                            <th>Korisnik</th>
                            <th>Oporavilište</th>
                            <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody id="user-role">
                            @foreach ($users as $user)
                            <tr>
                                <form action="{{ route('role-mapping-add') }}" method="post">
                                    @csrf

                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <input type="hidden" name="email" value="{{ $user->email }}">
                                    <td>
                                        <input id="{{$user->id}}" type="checkbox" {{ $user->hasRole('Administrator') ? 'checked' : '' }} name="administrator">
                                    </td>
                                    <td>
                                        <input id="{{$user->id}}" type="checkbox" {{ $user->hasRole('Korisnik') ? 'checked' : '' }} name="user">
                                    </td>
                                    <td>
                                        <input id="{{$user->id}}" type="checkbox" {{ $user->hasRole('Oporavilište') ? 'checked' : '' }} name="shelter">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-xs btn-sm btn-primary">Spremi</button>
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

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Dopuštenja</h6>

                @if($msg = Session::get('permissions'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table" id="permission">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission</th>
                                <th>Create</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Generate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <form action="{{ route('permissionAdd') }}" method="post">
                                    @csrf

                                    <td>0</td>
                                    <td>{{ $role->name }}</td>
                                    <input type="hidden" name="role" value="{{ $role->id }}">
                                    <td>
                                        <input id="{{ $role->id }}" type="checkbox" {{ $role->hasPermissionTo('create') == 1 ? 'checked' : '' }} name="create">
                                    </td>
                                    <td>
                                        <input id="{{ $role->id }}" type="checkbox" {{ $role->hasPermissionTo('edit') == 1 ? 'checked' : '' }} name="edit">
                                    </td>
                                    <td>
                                        <input id="{{ $role->id }}" type="checkbox" {{ $role->hasPermissionTo('delete') == 1 ? 'checked' : '' }} name="delete">
                                    </td>
                                    <td>
                                        <input id="{{ $role->id }}" type="checkbox" {{ $role->hasPermissionTo('generate') == 1 ? 'checked' : '' }} name="generate">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-xs btn-sm btn-primary">Spremi</button>
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

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
    <script>
        $('#user-role').find('input[type="checkbox"]').on('change', function() {
            $(this).closest('tr').find('input').not(this).prop('checked', false);
        });

        var roleTable = $("#role").DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
            },
            pageLength: 10,
        });

        var permissionTable = $("#permission").DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
            },
            pageLength: 10,
        });
    </script>
@endpush