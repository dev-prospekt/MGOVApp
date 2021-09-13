@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <div>
                <a href="/shelter/{{ $animalItem->shelter_id }}/animal/{{ $animalItem->shelterCode }}" class="btn btn-primary">
                    <i data-feather="left" data-toggle="tooltip" title="Connect"></i>
                    Natrag
                </a>
            </div>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4 stretch-card">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("animal_item.update", $animalItem->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="row">
                    
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Veličina</label>
                                    <input type="text" class="form-control" name="animal_size" value="{{ $animalItem->animal_size }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Spol</label>
                                    <input type="text" class="form-control" name="animal_gender" value="{{ $animalItem->animal_gender }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Lokacija</label>
                                    <input type="text" class="form-control" name="location" value="{{ $animalItem->location }}" required>
                                </div>
                    
                                <button type="submit" class="btn btn-primary mr-2">Ažuriraj</button>
                            </div>
                    
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="animalItemFile" enctype="multipart/form-data">
                        <input type="hidden" id="animal_item_id" name="animal_item_id" value="{{$animalItem->id}}">

                        <div class="form-group">
                            <label>Naziv dokumenta</label>
                            <input type="text" class="form-control" id="file_name" name="file_name">
                        </div>

                        <div class="form-group">
                            <label>Dokument</label>
                            <input type="file" class="form-control border" id="myDropify" name="filenames">
                        </div>
            
                        <button type="submit" class="btn btn-primary mr-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/dropify.js') }}"></script>
    <script>
        $(function() {
            // Upload Image
            $("#animalItemFile").submit(function(e){
                e.preventDefault();
                let formData = new FormData(this);

                if($("#file_name").val() == '' || $("#myDropify").val() == ''){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ispunite polja!',
                    });
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "/animal_item/file",
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        if(result.msg == 'success'){
                            Swal.fire(
                                'Odlično!',
                                'Uspješno ste dodali dokument!',
                                'success'
                            ).then((result) => {
                               location.reload(); 
                            });
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Nešto je pošlo po zlu!',
                            });
                        }
                    }
                });
            });
        })
    </script>
@endpush