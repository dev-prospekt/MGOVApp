@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div> 
        <h5 class="mb-3 mb-md-0">{{ isset($founders[0]) ? $founders[0]->shelter->name : '' }}</h5>
    </div>
    <div>      
     
    </div>
  </div>
<div class="row">
    <div class="col-md-7 stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Nalaznici</h6>
                        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                    </div>
                    <div>
                        <a href="{{ route('shelters.founders.create', $shelter->id) }}" class="create btn btn-sm btn-primary">Dodaj novog</a>
                    </div>
                </div>

                @if($msg = Session::get('msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                @if($error = Session::get('error'))
                <div id="dangerMessage" class="alert alert-danger">
                    @foreach ($error as $err)
                        <p>{{ $err }}</p>
                    @endforeach
                </div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="founder-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>PREZIME</th>
                                <th>KONTAKT</th>
                                <th>SLUŽBA</th>
    
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Nalaznici</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="founderservice-add btn btn-sm btn-primary">Dodaj</a>
                    </div>
                </div>

                <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                @if($msg = Session::get('founder-service-msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="founder-service">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($founderService as $item)
                            <tr>
                                <th>{{ $item->id }}</th>
                                <th>{{ $item->name }}</th>
                                <th>
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" data-href="{{ route('founder-service.edit', $item->id) }}">Uredi</a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" data-href="{{ route('founder-service.destroy', $item->id) }}">Obriši</a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="modal"></div>

@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
      $(function() {
        var table = $('#founder-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('shelters.founders.index', [$shelter->id] ) !!}',
            columns: [
                { data: 'id', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'lastname', name: 'lastname'},
                { data: 'contact', name: 'contact'},
                { data: 'service', name: 'service'},
                { data: 'action', name: 'action'},
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
            }
        });

        var founderService = $("#founder-service").DataTable({
            pageLength: 5,
            lengthChange: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
            }
        });

        // Add
        $(".founderservice-add").on('click', function(e){
            e.preventDefault();

            $.ajax({
                url: "{{ route('founder-service.create') }}",
                method: 'GET',
                success: function(result) {
                    $(".modal").show();
                    $(".modal").html(result['html']);
                }
            });
        });

        // Delete
        $('#founder-service').on('click', '.delete', function(e){
            e.preventDefault();
            url = $(this).attr('data-href');

            Swal.fire({
                title: 'Jeste li sigurni?',
                text: "Želite obrisati i više neće biti dostupan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Odustani',
                confirmButtonText: 'Da, obriši!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {_token: '{{csrf_token()}}'},
                        success: function (results) {
                            if(results.status == 'ok'){
                                $("#successMessage").show();
                                $("#successMessage").html(results.message);

                                setInterval(function(){
                                    location.reload();
                                }, 1000);
                            }
                        }
                    });
                }
            });
        });

        // Edit
        $('#founder-service').on('click', '.edit', function(e){
            e.preventDefault();
            url = $(this).attr('data-href');

            $.ajax({
                url: url,
                method: 'GET',
                success: function(result) {
                    $(".modal").show();
                    $(".modal").html(result['html']);
                }
            });
        });

        // Delete
        $('#founder-table').on('click', '.trash', function(e){
            e.preventDefault();

            url = $(this).attr('data-href');

            Swal.fire({
                title: 'Jeste li sigurni?',
                text: "Želite obrisati nalaznika i više neće biti dostupan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Odustani',
                confirmButtonText: 'Da, obriši!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {_token: '{{csrf_token()}}'},
                        success: function (results) {
                            table.ajax.reload();
                        }
                    });
                }
            });
        });

        // Close Modal
        $(".modal").on('click', '.modal-close', function(){
            $(".modal").hide();
        });
    });
  </script>
@endpush
