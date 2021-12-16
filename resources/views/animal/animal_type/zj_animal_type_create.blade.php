@extends('layout.master')


@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />  
@endpush

@section('content')
    <div class="row">
        <div class="col-md-8">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div>              
                    <p class="card-description">Dodaj invazivnu jedinku</p>
                </div>
                <div>
                    <a href="{{ url("/zj_animal_type") }}" class="btn btn-sm  btn-warning">Pregled svih</a>
                </div>
            </div>
              <form action="{{ route('store_zj_animal_type') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Naziv Jedinke</label>
                    <input type="text" class="form-control" name="name">
                    @error('name')
                        <div class="text-danger">{{$errors->first('name') }} </div>
                    @enderror
                </div>
                  <div class="form-group">
                    <label>Latinski Naziv</label>
                    <input type="text" class="form-control" name="latin_name">
                    @error('latin_name')
                        <div class="text-danger">{{$errors->first('latin_name') }} </div>
                    @enderror
                </div>  
                <div class="form-group">
                    <label>Oznaka Jedinke</label>
                    <select class="js-example-basic-multiple w-100" multiple="multiple" name="animal_code[]">
                        <option value="">Izbornik</option>     
                        @foreach ($animalCodes as $itemCode)
                          <option value="{{ $itemCode->id }}"> {{ $itemCode->name }} - {{ $itemCode->desc }}</option>            
                        @endforeach  
                    </select>
                    @error('animal_code')
                        <div class="text-danger">{{$errors->first('animal_code') }} </div>
                    @enderror
                </div>
                <div class="form-group">
                  <label>Tip Jedinke</label>
                  <select class="js-example-basic-multiple w-100" multiple="multiple" name="animal_type[]">
                      <option value="">Izbornik</option>     
                        <option value="{{ $animalType->id }}" selected>{{ $animalType->type_code }} - {{ $animalType->type_name }}</option>                     
                  </select>
                  @error('animal_type')
                      <div class="text-danger">{{$errors->first('animal_type') }} </div>
                  @enderror
                </div>
                <div class="form-group">
                  <label>Porodica</label>
                  <select class="js-example-basic-single w-100" name="animal_category" id="">   
                    <option value="">----</option>       
                      @foreach ($animalCategory as $animalCat)
                        <option value="{{ $animalCat->id }}">{{ $animalCat->latin_name }} - {{ $animalCat->name }} </option>
                      @endforeach    
                  </select>  
                  @error('animal_category')
                      <div class="text-danger">{{$errors->first('animal_category') }} </div>
                  @enderror
                </div>    
                <div class="form-group">
                  <label>Razred</label>
                  <select class="form-control" name="animal_system_category" id="">     
                      <option value="">----</option>   
                      @foreach ($animalSystemCategory as $animalSystemCat)
                        <option value="{{ $animalSystemCat->id }}"> {{ $animalSystemCat->latin_name }} - {{ $animalSystemCat->name }} </option>
                      @endforeach
                  </select>
                  @error('animal_system_category')
                      <div class="text-danger">{{$errors->first('animal_system_category') }} </div>
                  @enderror
                </div>  
                <button type="submit" class="btn btn-info mr-2 mt-2">Dodaj Jedinku</button>
              </form>
            </div>
          </div>
        </div>      
    </div><!-- end Row -->
        

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/form-validation.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>

@endpush

@endsection