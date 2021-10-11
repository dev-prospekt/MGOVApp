@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <div>
            <a href="/shelter/{{ $animalItem->first()->shelter_id }}" class="btn btn-primary">
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
                        <th>KATEGORIJA</th>
                        <th>SPOL</th>
                        <th>VELIČINA</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($animalItem as $anim)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $anim->animal->name }}</td>
                                <td>{{ $anim->animal->latin_name }}</td>
                                <td>{{ $anim->animal->animalCategory->latin_name }}</td>
                                <td>{{ $anim->animal_gender }}</td>
                                <td>{{ $anim->animalSizeAttributes->name ?? '' }}</td>
                                <td>
                                    <a href="{{ route('animal_item.show', $anim) }}" class="btn btn-info">
                                        Info
                                    </a>
                                    <a href="{{ route('animal_item.edit', $anim) }}" class="btn btn-info">
                                        Uredi
                                    </a>
                                    <button type="button" class="btn btn-primary premjesti" data-id="{{$anim->id}}">
                                        Premjesti
                                    </button>
                                    <a target="_blank" href="/generate-pdf/{{ $anim->id }}" class="btn btn-secondary">
                                        Izvjestaj
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h6>Dodatni opisni podaci oporavilišta o preuzimanju</h6>
                </div>

                <hr>

                <p>{{ $animalItem->first()->animal->shelters->first()->pivot->description }}</p>
            </div>
        </div>
    </div>

</div> <!-- row -->

<!-- Modal -->
<button type="button" id="openModal" class="btn btn-primary d-none" data-toggle="modal" data-target="#exampleModalCenter">
</button>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form id="changeShelterForm" action="" method="POST">
                    @csrf
                    @method('POST')
        
                    <div class="form-group">
                        <h6>Oporavilište u kojem se nalazi:</h6>
                        <span>{{ $animalItem->first()->shelter->name }}</span>
                    </div>
                    <input type="hidden" name="animal_id" id="animal_id">
                    <input type="hidden" name="shelter_code" id="shelterCode">

                    <select id="shelter_id" name="shelter_id">
                        <option value="">Odaberite oporavilište</option>
                        @foreach ($shelters as $shelter)
                            @if ($animalItem->first()->shelter->id != $shelter->id)
                                <option value="{{$shelter->id}}">{{$shelter->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button type="button" id="save" class="btn btn-primary">Ažuriraj</button>
    </div>
    </div>
</div>
</div>

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