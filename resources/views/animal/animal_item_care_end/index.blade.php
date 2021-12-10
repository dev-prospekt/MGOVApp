@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
@endpush

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
  <div> <h5 class="mb-3 mb-md-0">{{ $animalItem->shelter->name }}</h5></div>
  <div>      
     <a href="/shelters/{{ $animalItem->shelter_id }}/animal_groups/{{ $animalItem->animal_group_id }}" type="button" class="btn btn-primary btn-sm btn-icon-text">
        Povratak na popis
        <i class="btn-icon-append" data-feather="clipboard"></i>
      </a> 
      
      <a href="/shelters/{{ $animalItem->shelter_id }}/animal_groups/{{ $animalItem->animal_group_id }}" type="button" class="btn btn-info btn-sm btn-icon-text">
        Izvještaj jedinke
        <i class="btn-icon-append" data-feather="clipboard"></i>
      </a> 
  </div>
</div>
<ul class="nav shelter-nav">
  <li class="nav-item">
    <a class="nav-link " href="{{ route('shelters.animal_groups.animal_items.show', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">{{ $animalItem->animal->name }} - {{ $animalItem->animal->latin_name }}</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Dokumentacija jedinke</a>
  </li>

  <li class="nav-item">
    <a class="nav-link active" href="{{ route('shelters.animal_groups.animal_items.animal_item_care_end.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Završetak skrbi</a>
  </li>
</ul>
<div class="row">
  <div class="col-md-7">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Skrb - prestanak</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Eutanazija</a>
      </li>
    </ul>
    <div class="tab-content border border-top-0" id="myTabContent"><!-- tab container -->
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="card rounded">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-2">
                  <h6 class="card-title mb-0">Kraj skrbi jedinke</h6>
                  <div>
                    <p class="text-muted">Početak skrbi - <span class="text-info">{{ $animalItem->dateRange->start_date->format('d.m.Y.') }}</span></p>
                  </div>
              </div>
              <div class="row"><div class="separator separator--small"></div></div>
    
              @if ($animalItem->animal->animalType->first()->type_code == 'IJ')
    
              @endif
    
              @if($msg = Session::get('euthanasiaMsg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif      
                <div class="form-group mt-2">
                  <label>Datum prestanka skrbi o životinji</label>
                  <div class="input-group date datepicker" id="dateEndcarePicker">
                      <input type="text" name="end_date" class="form-control end_date" value="{{ $animalItem->dateRange->end_date }}">
                      <span class="input-group-addon">
                          <i data-feather="calendar"></i>
                      </span>
                  </div>
                </div>                       
          </div>
        </div>
      </div><!-- end tab -->
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

      </div><!-- end tab -->
    </div><!-- end tab container -->


  
  </div>

  <div class="col-md-5">
    <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between">
        <div><h6 class="card-title">Cijene skrbi</h6> </div> 
        {{-- <a href="{{ route('shelters.animal_groups.animal_items.edit', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" class="btn btn-primary btn-icon-text btn-sm" type="button">
          Izmjeni podatke
          <i class="btn-icon-append" data-feather="box"></i>
        </a> --}}
      </div> 
      @if($msg = Session::get('update_animal_item'))
      <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
      @endif      
        <div class="row">
          <div class="col-md-4 grid-margin">    
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv vrste: </label>
                <p class="text-muted">{{ $animalItem->animal->name }}</p>
              </div>
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Latinski naziv:</label>
                <p class="text-muted">{{ $animalItem->animal->latin_name ?? ''  }}</p>
              </div>
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Datum pronalaska:</label>
                <p class="text-muted">{{ $animalItem->animal_date_found->format('d.m.Y') ?? '' }}</p>
              </div>
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Način držanja:</label>
                <p class="text-warning">{{ $animalItem->solitary_or_group ?? '' }}</p>
              </div>

              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hibernacija:</label>
                <p class="text-info">Ne</p>
              </div>

          </div> 

          <div class="col-md-4 grid-margin">
            
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Lokacija pronalaska: </label>
              <p class="text-muted">{{ $animalItem->location ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Nalaznik: </label>
              <p class="text-muted">{{ $animalItem->founder->name }} - {{ $animalItem->founder->service }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Napomena nalaznika: </label>
              <p class="text-muted">{{ $animalItem->founder_note }}</p>
            </div>
          </div>  
          
          <div class="col-md-4 grid-margin">    
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Spol:</label>
              <p class="text-muted">{{ $animalItem->animal_gender ?? '' }}</p>
            </div>

            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Veličina:</label>
              <p class="text-muted">{{ $animalItem->animalSizeAttributes->name ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dob Jedinke:</label>
              <p class="text-muted">{{ $animalItem->animal_age ?? '' }}</p>
            </div>           
        </div>     
      </div>   
            
    </div>

  </div>

  </div><!-- end card -->
  
  
</div>
  
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/lightbox2/lightbox.min.js') }}"></script> 
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>

  <script>  
      $(function() {
        /*euthanasia js*/
          $("#euthanasia_file").fileinput({
              language: "cr",
              //required: true,
              showPreview: false,
              showUpload: false,
              showCancel: false,
              allowedFileExtensions: ["pdf"],
              elErrorContainer: '#error_euthanasia_file',
              msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
          });

        
          $('div#dateEndcarePicker input').datepicker({
              format: "mm/dd/yyyy",
              todayHighlight: true,
              autoclose: true,
          });
          /* $("div#datePickerExample").find(".end_date").datepicker('setDate', $("div#datePickerExample").find(".end_date").val()); */
            
      })
  </script>

  <script src="{{ asset('assets/js/select2.js') }}"></script>