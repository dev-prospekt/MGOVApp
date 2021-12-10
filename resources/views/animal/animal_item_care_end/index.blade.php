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
          <form action="">     
            <div class="form-group mt-2">
              <label>Datum prestanka skrbi o životinji</label>
              <div class="input-group date datepicker" id="dateEndcarePicker">
                  <input type="text" name="end_date" class="form-control end_date" value="{{ $animalItem->dateRange->end_date }}">
                  <span class="input-group-addon">
                      <i data-feather="calendar"></i>
                  </span>
              </div>
            </div>    
            <div class="form-group">
              <label>Razlog prestanka skrbi</label>
              <select class="form-control end_care_type" name="end_care_type" id="endCareType" required>
                <option value="">----</option>
                @foreach ($careEndTypes as $careEndType)
                    <option value="{{ $careEndType->id }}">{{ $careEndType->name }}</option>
                @endforeach  
              </select>  
            </div>  
            <div class="form-group" id="releaseLocation">
              <label for="releaseLocation">Lokacija puštanja</label>
              <input type="text" name="release_location" class="form-control" placeholder="... lokacija ili gps kordinate">
            </div>   
            
            <div class="form-group" id="permanentKeepName">
              <label for="permanentKeepName">Naziv pravne/fizičke osobe ili institucije</label>
              <input type="text" name="permanent_keep_name" class="form-control" placeholder="Naziv pravne/fizičke osobe ili institucije gdje se jedinka zbrinjava">
            </div>
           
            <div class="form-group" id="euthanasiaShelter">
              <div class="form-check">
                <label class="form-check-label">
                  <input checked type="radio" class="form-check-input euthanasia_type" name="euthanasia_type" id="euthanasiaShelterType" value="Izvedeno u oporavilištu">
                  Izvedeno u oporavilištu
                <i class="input-frame"></i></label>
              </div>
            
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input euthanasia_type" name="euthanasia_type" id="euthanasiaOuterType" value="Vanjski pružatelj usluge">
                  Vanjski pružatelj usluge
                <i class="input-frame"></i></label>
              </div> 
              
              <div class="form-group">
                <label for="">Odabir Veterinara/Službe</label>
                <select class="form-control" name="" id="" required>
                 
                  <option value="">---</option>
                  <option value="{{ $vetenaryStaff['id'] ?? '' }}">{{ $vetenaryStaff['name'] ?? '' }}</option>
                </select>
              </div>

              <div class="form-group" id="euthanasiaPrice">
                <div class="form-group">
                  <label for="euthanasiaPrice">Cijena - iznos</label>
                  <input type="text" class="form-control" name="euthanasia_price" placeholder="cijena u HRK">
                </div>
                <div class="form-group">
                  <label>Učitaj račun</label>
                  <input id="euthanasiaInvoice" type="file" name="euthanasia_invoice" class="file-upload-default">
                  <div id="errorEuthanasiaInvoice"></div>         
                </div>           
              </div> 
            </div>
            <div class="form-group" id="careEndOther">
              <label for="releaseLocation">Unos</label>
              <input type="text" name="care_end_other" class="form-control" placeholder="... slobodan unos">
            </div>                   
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-warning  mr-2">Spremite zapis</button>
            </div>            
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
<script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>

@endpush

@push('custom-scripts')

  <script>  
      $(function() {
        $("#releaseLocation").hide();
        $("#permanentKeepName").hide();
        $("#euthanasiaShelter").hide();
        $("#careEndOther").hide();
        $("#euthanasiaPrice").hide();

        //fields based on dropdown
        $("#endCareType").change(function(){
          $("#euthanasiaPrice").hide();
          var id = $("#endCareType").val();             
            id == 1 ?  $("#releaseLocation").show() : $("#releaseLocation").hide();
            id == 2 ?  $("#permanentKeepName").show() : $("#permanentKeepName").hide();
            id == 3 ?  $("#euthanasiaShelter").show() : $("#euthanasiaShelter").hide();  
            id == 4 ?  $("#careEndOther").show() : $("#careEndOther").hide();                          
        });

        $("input[name=euthanasia_type]").change(function(){

          if($("#euthanasiaOuterType").is(':checked')){
              $("#euthanasiaPrice").show();
          }else if($("#euthanasiaShelterType").is(':checked')){
            $("#euthanasiaPrice").hide();
          } else {
            $("#euthanasiaPrice").hide();
          }
        });

        $("#euthanasiaInvoice").fileinput({
          dropZoneEnabled: false,
          language: "cr",
          showPreview: false,
          showUpload: false,
          allowedFileExtensions: ["jpg", "png", 'doc', 'pdf', 'xls'],
          elErrorContainer: '#errorEuthanasiaInvoice',
          msgInvalidFileExtension: 'Nevažeća fotografija, Podržani su "{extensions}" formati.'

         });
    
      });
  </script>
  @endpush