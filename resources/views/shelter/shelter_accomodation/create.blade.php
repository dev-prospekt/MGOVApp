@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />  
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
      <h4 class="mb-3 mb-md-0">Smještajne jedinice oporavilišta</h4>
  </div>
</div>
   
    <div class="row">
      <div class="col-md-12">@if($msg = Session::get('msg'))
    
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ $msg }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif</div>
      <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="card-description">Osigurane opremljene nastambe</p>
                    <form action="{{ route('shelter_accomodation_box.store', $shelter_id) }}" method="POST" id="shelterAccomodation" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
            
                        <div class="form-group">
                            <label class="control-label">Tip Nastambe</label>
                            <input type="hidden" name="shelter_id" id="shelterID" value="{{ $shelter_id }}">
                            <select class="js-example-basic w-100" name="accomodation_box_type">
                                <option selected disabled>---</option>
                                @foreach ($accomodation_shelter as $accomodation)
                                    <option value="{{ $accomodation['id'] }}">{{ $accomodation['name'] }}</option>
                                @endforeach
                            </select>   
                            @error('accomodation_box_type')
                                <div class="text-danger">{{$errors->first('accomodation_box_type') }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" class="form-control size" name="accomodation_box_name" id="accomodationSize" placeholder="Naziv nastambe npr. Kavez 01"> 
                            @error('accomodation_box_name')
                                <div class="text-danger">{{$errors->first('accomodation_box_name') }} </div>
                            @enderror
                        </div>
                                
                        <div class="form-group">
                            <label>Dimenzije</label>
                            <input type="text" class="form-control size" name="accomodation_box_size" id="accomodationSize" placeholder="dimenzija u metrima D x Š x V"> 
                            @error('accomodation_box_size')
                                <div class="text-danger">{{$errors->first('accomodation_box_size') }} </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Opis nastambe</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="accomodation_box_desc" rows="5"></textarea>
                            @error('accomodation_box_desc')
                                <div class="text-danger">{{$errors->first('accomodation_box_desc') }} </div>
                            @enderror
                        </div>  
            
                                    
                    <div class="form-group">
                        <label>Popratna fotodokumentacija</label>
                        <div class="file-loading">
                            <input  name="accomodation_box_photo[]" type="file" id="accomodationBoxPhoto" multiple>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit">Spremi nastambu</button>                                   
                </form>
            </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <p class="card-description">Osigurani opremljeni prostori oporavilišta</p>
                    <form action="{{ route('shelter_accomodation_place.store', $shelter_id) }}" method="POST" id="shelterAccomodation" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
            
                        <div class="form-group">
                            <label class="control-label">Tip Prostora</label>
            
                            <select class="js-example-basic w-100" name="accomodation_place_type">

                                <option selected disabled>---</option>
                                @foreach ($accomodation_place  as $accomodation)
                                    <option value="{{ $accomodation['id'] }}">{{ $accomodation['name'] }}</option>
                                @endforeach
                            </select>  
                            @error('accomodation_place_type')
                                <div class="text-danger">{{$errors->first('accomodation_place_type') }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" class="form-control size" name="accomodation_place_name" id="accomodationSize" placeholder="Naziv prostora pr. čvrsti zidani objekt"> 
                            @error('accomodation_place_name')
                                <div class="text-danger">{{$errors->first('accomodation_place_name') }} </div>
                            @enderror
                        </div>
                                
                        <div class="form-group">
                            <label>Dimenzije</label>
                            <input type="text" class="form-control size" name="accomodation_place_size" id="accomodationPlaceSize" placeholder="dimenzija u metrima D x Š x V"> 
                            @error('accomodation_place_size')
                                <div class="text-danger">{{$errors->first('accomodation_place_size') }} </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Opis nastambe</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="accomodation_place_desc" rows="5"></textarea>
                            @error('accomodation_place_desc')
                                <div class="text-danger">{{$errors->first('accomodation_place_desc') }} </div>
                            @enderror
                        </div>  
            
                                    
                    <div class="form-group">
                        <label>Popratna fotodokumentacija</label>
                        <div class="file-loading">
                            <input  name="accomodation_space_photo[]" type="file" id="accomodationSpacePhoto" multiple>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit">Spremi nastambu</button>                                   
                </form>
            </div>
        </div>
      </div>      
    </div><!-- end Row -->


@push('plugin-scripts')
<script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>

@endpush

@push('custom-scripts')
<script>
    $("#accomodationBoxPhoto, #accomodationSpacePhoto").fileinput({
        dropZoneEnabled: false,
        language: "cr",
        showPreview: false,
        showUpload: false,
        allowedFileExtensions: ["jpg", "png", "gif"]
    });
</script>

@endpush

@endsection
  


