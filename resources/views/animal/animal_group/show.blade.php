@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <div>
            <a href="/shelter/{{ $animal_items->first()->shelter_id }}" class="btn btn-primary">
                <i data-feather="left" data-toggle="tooltip" title="Connect"></i>
                Natrag
            </a>
        </div>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">Podatci</h6>

                @if($msg = Session::get('msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                <table class="table" id="animal-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAZIV</th>
                            <th>LATINSKI NAZIV</th>
                            <th></th>
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
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<script>
$(function() {
    var table = $('#animal-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('shelters.animal_groups.show', [$animal_group->shelters->first()->id, $animal_group->id]) !!}',
        columns: [
            { data: 'id', name: 'id'},
            { data: 'name', name: 'name'},
            { data: 'latin_name', name: 'latin_name'},
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
        }
    });
});
</script>

<script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush