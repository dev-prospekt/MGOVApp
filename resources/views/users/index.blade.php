@extends('layout.master')

@section('content')
<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin stretch-card">
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

                <div class="" id="msg"></div>

                @if($msg = Session::get('msg'))
                <div class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                <table class="table" id="users-table">
                    <thead>
                    <tr>
                        <th class="w-10">#</th>
                        <th class="w-10">IME</th>
                        <th class="w-10">EMAIL</th>
                        <th class="w-10">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>

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
      $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('users:dt') !!}',
                columns: [
                    { data: 'id', name: 'id'},
                    { data: 'name', name: 'name'},
                    { data: 'email', name: 'email'},
                    { data: 'action', name: 'action'}
                ],
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
                        $('#users-table').DataTable().ajax.reload();
                        $("#msg").addClass('alert alert-success');
                        $("#msg").html(result.msg);
                    }
                });
            });
        })
  </script>
@endpush