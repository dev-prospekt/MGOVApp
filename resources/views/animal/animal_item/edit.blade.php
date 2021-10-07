@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <div>
                <a href="/shelter/{{ $animalItem->shelter_id }}/animal/{{ $animalItem->shelter_code }}" class="btn btn-primary">
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
                                    <select class="form-control" name="animal_size_attributes_id" id="">
                                        <option value="">Odaberi</option>
                                        @foreach ($size->sizeAttributes as $siz)
                                            <option value="{{ $siz->id }}">{{ $siz->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('animal_size_attributes_id')
                                        <div class="text-danger">{{$errors->first('animal_size_attributes_id') }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Dob jedinke</label>
                                    <select class="form-control" name="animal_dob" id="">
                                        <option value="">Odaberi</option>
                                        <option value="ADL">ADL (adultna)</option>
                                        <option value="JUV">JUV (juvenilna)</option>
                                        <option value="SA">SA (subadultna)</option>
                                    </select>
                                    @error('animal_dob')
                                        <div class="text-danger">{{$errors->first('animal_dob') }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Spol</label>
                                    <select class="form-control" name="animal_gender" id="">
                                        <option value="">Odaberi</option>
                                        <option value="muzjak">M (mužjak)</option>
                                        <option value="zenka">Ž/F (ženka)</option>
                                        <option value="nije moguce odrediti">N (nije moguće odrediti)</option>
                                    </select>
                                    @error('animal_gender')
                                        <div class="text-danger">{{$errors->first('animal_gender') }} </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Lokacija</label>
                                    <input type="text" class="form-control" name="location" value="{{ $animalItem->location }}" required>
                                    @error('location')
                                        <div class="text-danger">{{$errors->first('location') }} </div>
                                    @enderror
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
                    <div class="mb-2">
                        @if($msg = Session::get('msg'))
                        <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                        @endif
                    </div>

                    <form method="POST" id="animalItemFile" action="/animal_item/file" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="animal_item_id" name="animal_item_id" value="{{$animalItem->id}}">

                        <div class="form-group">
                            <label>Dokument</label>
                            <input type="file" class="form-control border" id="myDropify" name="filenames[]" multiple>
                            @error('filenames')
                                <div class="text-danger">{{$errors->first('filenames') }} </div>
                            @enderror
                        </div>
            
                        <button type="submit" class="btn btn-primary mr-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-2">
                        <h6 class="card-title">Dokumenti životinje</h6>
                    </div>
                    
                    @if ($mediaItems)
                        @foreach ($mediaItems as $file)
                            <div id="findFile">
                                <div>
                                    <a class="text-muted mr-2" target="_blank" data-toggle="tooltip" data-placement="top" 
                                        href="{{ $file->getUrl() }}">
                                        {{ $file->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @endif

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
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
@endpush