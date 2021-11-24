@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="row">
    <div class="col-lg-8 col-xl-8 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">Podatci</h6>

                @if($msg = Session::get('msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive-sm">
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

    <div class="col-md-4">
        <div class="card grid-margin">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 grid-margin">
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv: </label>
                            <p class="text-muted">{{ $animal_items->first()->animal->name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Latinski naziv: </label>
                            <p class="text-muted">{{ $animal_items->first()->animal->latin_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin">
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ukupni broj:</label>
                            <p class="text-muted">
                                {{ $animal_items->count() }}
                            </p>
                        </div>
                    </div>
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
            { data: 'action', name: 'action'},
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
        },
        pageLength: 5
    });
});
</script>

<script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush