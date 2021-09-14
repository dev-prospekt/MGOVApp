@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Korisnici</h6>
                        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                    </div>
                    <div>
                        <a href="{{ route("user.create") }}" class="btn btn-primary">Dodaj</a>
                    </div>
                </div>

                <div class="" id="msg"></div>

                @if($msg = Session::get('msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                <table class="table" id="users-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>IME</th>
                        <th>EMAIL</th>
                        <th>OPORAVILIŠTE</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-xl-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table" id="restore">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>IME</th>
                        <th>EMAIL</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($usersTrashed as $userTrash)
                            <tr>
                                <td>{{ $userTrash->id }}</td>
                                <td>{{ $userTrash->name }}</td>
                                <td>{{ $userTrash->email }}</td>
                                <td>
                                    <a href="/restore/{{ $userTrash->id }}" class="btn btn-primary">Restore</a>
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


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
      $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('users:dt') !!}',
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'shelter', name: 'shelter.name'},
                    { data: 'action', name: 'action'},
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
                }
            });

            // Delete
            $('#users-table').on('click', '#bntDeleteUser', function(e){
                e.preventDefault();
                var id = $(this).find('#userId').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "user/"+id,
                    method: 'DELETE',
                    success: function(result) {
                        if(result.msg == 'success'){
                            $('#users-table').DataTable().ajax.reload();

                            Swal.fire(
                                'Odlično!',
                                'Uspješno ste ugasili korisnika!',
                                'success'
                            ).then((result) => {
                               location.reload(); 
                            });
                        }
                    }
                });
            });
        })
  </script>
@endpush
