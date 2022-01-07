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
    <a class="nav-link active" href="{{ route('shelters.animal_groups.animal_items.animal_item_care_end.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">
    {{ $animalItem->animal_item_care_end_status ? 'Završetak skrbi' : 'Cijene skrbi' }}
    </a>
  </li>
</ul>
@if ($animalItem->animal_item_care_end_status == true)
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

          @if($msg = Session::get('euthanasiaMsg'))
            <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif   

          <form action="/animalItem/update/{{$animalItem->id}}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @method('POST')  

            <input type="hidden" class="shelter_id" name="shelter_id" value="{{ $shelter->id }}">

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
                  <input type="radio" class="form-check-input euthanasia_type" name="euthanasia_type" id="euthanasiaShelterType" value="Izvedeno u oporavilištu">
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
                <select class="form-control" id="vetenaryStaff" name="vetenaryStaff" id="">
                  {{-- <option value="">---</option>
                  <option value="{{ $vetenaryStaff['id'] ?? '' }}">{{ $vetenaryStaff['name'] ?? '' }}</option> --}}
                </select>
              </div>

              <div class="form-group" id="euthanasiaPrice">
                <div class="form-group">
                  <label for="euthanasiaPrice">Cijena - iznos</label>
                  <input type="text" class="form-control" name="euthanasia_price" placeholder="cijena u HRK">
                </div>
                <div class="form-group">
                  <label>Učitaj račun</label>
                  <input type="file" id="euthanasiaInvoice" name="euthanasia_invoice">
                  <div id="errorEuthanasiaInvoice"></div>         
                </div>           
              </div> 
            </div>
            <div class="form-group" id="careEndOther">
              <label for="releaseLocation">Unos</label>
              <input type="text" name="care_end_other" class="form-control" placeholder="... slobodan unos">
            </div> 
            
            <div class="form-group" id="careEndDesc">
              <label for="careEndDesc">Opis (neobvezno)</label>
              <textarea name="care_end_description" class="form-control" rows="5"></textarea>
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
        
        <div class="row">
          <div class="col-md-4 grid-margin">    
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Solitarno: </label>
              <p class="text-muted">
                @if (!empty($animalItem->dateRange->end_date))
                  {{ isset($price->solitary_price) ? $price->solitary_price . 'kn' : '0kn' }}
                @endif
              </p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Grupa: </label>
              <p class="text-muted">
                @if (!empty($animalItem->dateRange->end_date))
                  {{ isset($price->group_price) ? $price->group_price . 'kn' : '0kn' }}
                @endif
              </p>
            </div>
          </div>
          <div class="col-md-4 grid-margin">   
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Proširena skrb: </label>
              <p class="text-muted">
                @if (!empty($animalItem->dateRange->end_date))
                  {{ ( isset($price->full_care) != 0 ) ? $price->full_care . 'kn' : '0kn' }}
                @endif
              </p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hibernacija: </label>
              <p class="text-muted">
                @if (!empty($animalItem->dateRange->end_date))
                  {{ isset($price->hibern) ? $price->hibern . 'kn' : '0kn' }}
                @endif
              </p>
            </div>
          </div>
        </div>

        @if (!empty($animalItem->euthanasia))
        <div class="row">
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Eutanazija: </label>
              <p class="text-muted">
                {{ $animalItem->euthanasia->price . 'kn' }}
              </p>
            </div>
          </div>
        </div>
        @endif

        <div class="row">
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ukupan trošak: </label>
              <p class="text-muted">
                @if (!empty($animalItem->dateRange->end_date))
                  {{ isset($price->total_price) ? $price->total_price . 'kn' : '0kn' }}
                @endif
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div><!-- end card -->
  
</div><!-- end row -->
  @else
  <!-- IF CARE END -->
  <div class="row">
    <div class="col-md-5">
      <div class="card">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><span class="text-danger">ZAVRŠENA SKRB</span></li>
            <li class="list-group-item">Trajanje skrbi, broj dana: <span class="text-warning">{{ $date->start_date->diffInDays($date->end_date) }}</span></li>
            <li class="list-group-item"><p class="text-light">Početak skrbi: <span class="text-light">{{ $animalItem->dateRange->start_date->format('d.m.Y') }}</span></p></li>
            <li class="list-group-item"><p class="text-light">Kraj skrbi: <span class="text-light">{{ $animalItem->dateRange->end_date->format('d.m.Y') }}</span></p></li>
            <li class="list-group-item">Razlog prestanka skrbi: <span class="text-warning">{{ $animalItem->careEnd->careEndType->name }}</span></li>
            <li class="list-group-item"><span class="text-muted">Opis:</span>
             {{ $animalItem->careEnd->care_end_description }}
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-7">    
      <div class="card">
        
        <div class="card-body">

          <div class="d-flex align-items-center justify-content-between">
            <h6 class="card-title">Podaci skrbi</h6>
          </div> 

          <div>
            @if ($animalItem->animal_item_care_end_status == false)
              @if ($animalItem->animal->animalType->first()->type_code == 'IJ')
                <p class="text-danger">Za invazivne jedinke se ne računa cijena osim ako je eutanazija</p>
              @endif
            @endif
          </div>
             
          @if($msg = Session::get('update_animal_item'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif         
          <div class="row">
            <div class="col-md-4 grid-margin">   
              
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Solitarno držanje: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->dateRange->end_date) && (isset($price->solitary_price)))
                    <span class="text-info {{ isset($price->hibern) ? 'line-through ' : '' }}">{{ (isset($price->solitary_price)) ? $price->solitary_price . 'kn' : '' }}</span>
                    @else
                    <span class="text-info">0.00 kn</span>
                  @endif
                </p>
                @if (!empty($solitaryGroup))
                  @foreach ($solitaryGroup as $item)
                    @if ($item->solitary_or_group == 'Solitarno')
                      <div>
                        <p class="text-muted">
                          Broj dana: <span class="text-warning">{{ $item->start_date->diffInDays($item->end_date) }}</span>
                        </p>
                        <p class="text-muted">
                          {{ $item->start_date->format('d.m.Y') . ' - ' . $item->end_date->format('d.m.Y') }}
                        </p>                
                      </div>
                    @endif
                  @endforeach
                @endif
              </div>
             
            </div>
            <div class="col-md-4 grid-margin">  
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Grupno držanje: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->dateRange->end_date) && (isset($price->group_price)) )
                  <span class="text-info {{ isset($price->hibern) ? 'line-through ' : '' }}" >{{ $price->group_price . 'kn'}}</span>
                    @else
                    <span class="text-info">0.00 kn</span>
                  @endif
                </p>
                @if (!empty($solitaryGroup))
                @foreach ($solitaryGroup as $item)
                  @if ($item->solitary_or_group == 'Grupa')
                    <div>        
                      <p class="text-muted">
                        Broj dana: <span class="text-warning">{{ $item->start_date->diffInDays($item->end_date) }}</span> 
                      </p>
                      <p class="text-muted">
                        {{ $item->start_date->format('d.m.Y') . ' - ' . $item->end_date->format('d.m.Y') }}
                      </p>
                    </div>
                  @endif
                @endforeach
              @endif
              </div> 
    
         
            </div>
            <div class="col-md-4 grid-margin"> 
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Proširena skrb: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->dateRange->end_date))
                  <span class="text-info  {{ isset($price->hibern) ? 'line-through ' : '' }}">{{ (isset($price->full_care) != 0 ) ? $price->full_care . 'kn' : '0kn' }}</span>
                  @endif
                </p>
                @if(!empty($animalItem->dateFullCare->first()))
                @foreach ($animalItem->dateFullCare as $full)
                  <p class="text-muted">
                    Broj dana: <span class="text-warning">{{$full->days}}</span>
                  </p>
                  <p class="text-muted">
                    {{$full->start_date->format('d.m.Y')}} - {{ $full->end_date->format('d.m.Y') }}
                  </p>
                @endforeach
              @endif
              </div>  
           
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 grid-margin">
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hibernacija: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->dateRange->end_date)  && (isset($price->hibern)))
                    <span class="text-info">{{  $price->hibern . 'kn'}}</span>
                    @if (!empty($date->hibern_start) && !empty($date->hibern_end))
                    <p class="text-muted">Broj dana: <span class="text-warning">{{ $date->hibern_start->diffInDays($date->hibern_end) }}</span></p>
                    <p class="text-muted">{{ $date->hibern_start->format('d.m.Y') . ' - ' . $date->hibern_end->format('d.m.Y') }}</p>
                    
                  @endif
                    @else
                    <span class="text-info">NE</span>
                  @endif
                </p>
              </div>
            </div>

            <div class="col-md-4 grid-margin">
              <div class="mt-2">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Eutanazija: </label>
                <p class="text-muted">
                  @if (!empty($animalItem->euthanasia))
                    {{ $animalItem->euthanasia->price . 'kn' }}

                    @if(!empty($animalItem->euthanasia->getMedia('euthanasia_invoice')->first()))
                    <p>
                      <a href="{{ $animalItem->euthanasia->getMedia('euthanasia_invoice')->first()->getUrl() }}" target="_blank">
                        {{ $animalItem->euthanasia->getMedia('euthanasia_invoice')->first()->name }}
                      </a>
                    </p>
                    @endif

                  @else
                    <span class="text-warning">NE</span>
                  @endif
                </p>
              </div> 
            </div>

            <div class="col-md-4 grid-margin">
              @if ($animalItem->animal_age == 'JUV(juvenilna)' && $animalItem->animal->animalCategory->animalSystemCategory->name != 'gmazovi')
            <p><code class="p-0">Napomena:</code></p>
            <p>JUV(juvenilna) + 30%</p>
          @endif
            </div>
          </div>

          <div class="row separator separator--small"></div>
            <div class="d-flex align-items-center justify-content-between mb-2">
              <div></div>        
                <div class="mt-2">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ukupan trošak: </label>
                  <p class="text-muted">
                    @if (!empty($animalItem->dateRange->end_date))
                      <h5 class="text-primary">{{ isset($price->total_price) ? $price->total_price . 'kn' : '' }}</h5>
                    @endif
                  </p>     
                </div>
            </div>
        </div>
      </div>
    </div>
  </div><!-- end row -->

@endif
  
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/lightbox2/lightbox.min.js') }}"></script> 
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>  
      $(function() {
        $('div#dateEndcarePicker input').datepicker({
            format: "mm/dd/yyyy",
            todayHighlight: true,
            autoclose: true,
        });

        // Veterirani
        $("input.euthanasia_type").on('click',function(){
          if($(this).val() == 'Izvedeno u oporavilištu'){
            var staff_id = 3;
          }
          if($(this).val() == 'Vanjski pružatelj usluge'){
            var staff_id = 4;
          }
          var shelter = $("input.shelter_id").val();

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
              }
          });
          $.ajax({
              url: "{{ route('getVet') }}",
              method: 'POST',
              data: {
                'staff_id': staff_id,
                'shelter_id': shelter,
              },
              success: function(data) {
                $('#vetenaryStaff').html(data.html);
              }
          });
        });
        // Veterirani

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

        $("input.euthanasia_type").change(function(){
          if($("#euthanasiaOuterType").is(':checked')){
            $("#euthanasiaPrice").show();
          }
          else if($("#euthanasiaShelterType").is(':checked')){
            $("#euthanasiaPrice").hide();
          } 
          else {
            $("#euthanasiaPrice").hide();
          }
        });

        /*euthanasia js*/
        $("#euthanasiaInvoice").fileinput({
          language: "cr",
          maxFileCount: 1,
          showPreview: false,
          showUpload: false,
          showCancel: false,
          allowedFileExtensions: ["jpg", "png", "doc", "pdf", "xls"],
          elErrorContainer: '#errorEuthanasiaInvoice',
          msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
        });
    
      });
  </script>
  @endpush
