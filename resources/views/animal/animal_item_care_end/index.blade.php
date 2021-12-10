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

    <div class="card">
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
        
        <form action="/animalItem/update/{{$animalItem->id}}" method="POST">
          @csrf
          @method('POST')
          
          <div class="form-group mt-2">
            <label>Datum prestanka skrbi o životinji</label>
            <div class="input-group date datepicker" id="dateEndcarePicker">
                <input type="text" name="end_date" class="form-control end_date" 
                value="{{ $animalItem->dateRange->end_date ? $animalItem->dateRange->end_date->format('m/d/Y') : null }}">
                <span class="input-group-addon">
                    <i data-feather="calendar"></i>
                </span>
            </div>
          </div>                       

          <button type="submit" id="submit" class="btn btn-primary mr-2 mt-3">Završi</button>
        </form>
      </div>
    </div>

  </div>

  <div class="col-md-5">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between">
          <div><h6 class="card-title">Cijene skrbi</h6> </div> 
        </div> 

        @if($msg = Session::get('update_animal_item'))
        <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
        @endif      

        <div class="row">
          <div class="col-md-4 grid-margin">   
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Grupa: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->shelterAnimalPrice))
                  {{ $price->group_price ? $price->group_price . 'kn' : '' }}
                  @endif
                </p>
              </div>
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Solitarno: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->shelterAnimalPrice))
                  {{ $price->solitary_price ? $price->solitary_price . 'kn' : '' }}
                  @endif
                </p>
              </div>
          </div>
          <div class="col-md-4 grid-margin">   
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Proširena skrb: </label>
              <p class="text-muted">
                @if (!empty($animalItem->shelterAnimalPrice))
                {{ $price->full_care != 0 ? $price->full_care . 'kn' : '' }}
                @endif
              </p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hibernacija: </label>
              <p class="text-muted">
                @if (!empty($animalItem->shelterAnimalPrice))
                {{ $price->hibern ? $price->hibern . 'kn' : '' }}
                @endif
              </p>
            </div>
          </div>

        </div>
        <div class="row">

          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ukupna cijena:</label>
              <p class="text-muted">

              </p>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div><!-- end card -->
  
</div>
  
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/lightbox2/lightbox.min.js') }}"></script> 
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
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
            
      })
  </script>

@endpush