@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
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

                {{ $animalItems->id }}

                <div class="table-responsive">
                <table class="table" id="animal-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>KATEGORIJA</th>
                        <th>SPOL</th>
                        <th>VELIČINA</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
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
                            <p class="text-muted">{{ $animalItems->animal->name }}</p>
                        </div>
                        <div class="mt-3">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Latinski naziv: </label>
                            <p class="text-muted">{{ $animalItems->animal->latin_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div> <!-- row -->

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>

    <script>
        $(function() {
            // Premjestaj
            $(".premjesti").click(function(){
                $("#openModal").trigger('click');

                id = $(this).attr("data-id");

                $.get( "/animal_item/getId/" + id, function( data ) {
                    console.log(data)
                    $('#changeShelterForm').attr('action', '/animal_item/changeShelter/'+id);
                    $('#animal_id').val(data.animal_id);
                    $('#shelterCode').val(data.shelter_code);
                });
                
            });

            $("#save").click(function(){
                $("#changeShelterForm").submit();
            });
        })
    </script>

    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush