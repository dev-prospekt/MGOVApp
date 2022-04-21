@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">

    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Spol</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="data-table-add btn btn-sm btn-primary" 
                        data-href="{{ route('podaci-create', [$model['spol']]) }}"
                        >
                            Dodaj
                        </a>
                    </div>
                </div>

                @if($msg = Session::get('animalDobMsg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animalDob as $item)
                            <tr>
                                <th>{{ $item->id }}</th>
                                <th>{{ $item->name }}</th>
                                <th>
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" 
                                    data-href="{{ route('podaci-edit', [$item->id, $model['spol']]) }}"
                                    >
                                        Uredi
                                    </a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" 
                                    data-href="{{ route('podaci-delete', [$item->id, $model['spol']]) }}"
                                    >
                                    Obriši
                                    </a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Način držanja</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="data-table-add btn btn-sm btn-primary" 
                        data-href="{{ route('podaci-create', [$model['solitary_group']]) }}"
                        >
                            Dodaj
                        </a>
                    </div>
                </div>

                @if($msg = Session::get('animal_solitary_or_group_msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animalSolitaryGroup as $item)
                            <tr>
                                <th>{{ $item->id }}</th>
                                <th>{{ $item->name }}</th>
                                <th>
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" 
                                    data-href="{{ route('podaci-edit', [$item->id, $model['solitary_group']]) }}"
                                    >
                                        Uredi
                                    </a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" 
                                    data-href="{{ route('podaci-delete', [$item->id, $model['solitary_group']]) }}"
                                    >
                                    Obriši
                                    </a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Stanje jedinke</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="data-table-add btn btn-sm btn-primary" 
                        data-href="{{ route('podaci-create', [$model['animal_status']]) }}"
                        >
                            Dodaj
                        </a>
                    </div>
                </div>

                @if($msg = Session::get('animal_status_msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animalStatus as $item)
                            <tr>
                                <th>{{ $item->id }}</th>
                                <th>{{ $item->name }}</th>
                                <th>
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" 
                                    data-href="{{ route('podaci-edit', [$item->id, $model['animal_status']]) }}"
                                    >
                                        Uredi
                                    </a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" 
                                    data-href="{{ route('podaci-delete', [$item->id, $model['animal_status']]) }}"
                                    >
                                    Obriši
                                    </a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Lokacija preuzimanja životinje</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="data-table-add btn btn-sm btn-primary" 
                        data-href="{{ route('podaci-create', [$model['location_takeover']]) }}"
                        >
                            Dodaj
                        </a>
                    </div>
                </div>

                @if($msg = Session::get('location_animal_takeover_msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animalLocationTakeover as $item)
                            <tr>
                                <th>{{ $item->id }}</th>
                                <th>{{ $item->name }}</th>
                                <th>
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" 
                                    data-href="{{ route('podaci-edit', [$item->id, $model['location_takeover']]) }}"
                                    >
                                        Uredi
                                    </a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" 
                                    data-href="{{ route('podaci-delete', [$item->id, $model['location_takeover']]) }}"
                                    >
                                    Obriši
                                    </a>
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

<hr>

<div class="row">

    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Razlog prestanka skrbi</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="data-table-add btn btn-sm btn-primary" 
                        data-href="{{ route('podaci-create', [$model['animal_care_end_type']]) }}"
                        >
                            Dodaj
                        </a>
                    </div>
                </div>

                @if($msg = Session::get('animal_care_end_status_msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>IME</th>
                                <th>Akcija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($animalItemCareEndType as $item)
                            <tr>
                                <th>{{ $item->id }}</th>
                                <th>{{ $item->name }}</th>
                                <th>
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" 
                                    data-href="{{ route('podaci-edit', [$item->id, $model['animal_care_end_type']]) }}"
                                    >
                                        Uredi
                                    </a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" 
                                    data-href="{{ route('podaci-delete', [$item->id, $model['animal_care_end_type']]) }}"
                                    >
                                    Obriši
                                    </a>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 col-xl-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Nalaznici</h6>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="data-table-add btn btn-sm btn-primary" 
                        data-href="{{ route('podaci-create', [$model['founder']]) }}"
                        >
                            Dodaj
                        </a>
                    </div>
                </div>

                @if($msg = Session::get('founder_services_msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
                    <table class="table" id="datatable">
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
                                    <a href="javascript:void(0)" class="edit btn btn-xs btn-info" 
                                    data-href="{{ route('podaci-edit', [$item->id, $model['founder']]) }}"
                                    >
                                        Uredi
                                    </a>
                                    <a href="javascript:void(0)" class="delete btn btn-xs btn-danger" 
                                    data-href="{{ route('podaci-delete', [$item->id, $model['founder']]) }}"
                                    >
                                    Obriši
                                    </a>
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
        var datatable = $("table#datatable").DataTable({
            pageLength: 5,
            searching: false,
            lengthChange: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
            }
        });

        // Add
        $(".data-table-add").on('click', function(e){
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

        // Edit
        $('table#datatable').on('click', '.edit', function(e){
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
        $('table#datatable').on('click', '.delete', function(e){
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
                                Swal.fire(
                                    'Odlično!',
                                    'Uspješno obrisano!',
                                    'success'
                                ).then((result) => {
                                    location.reload(); 
                                });
                            }
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