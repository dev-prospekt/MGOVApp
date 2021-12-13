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
      <a class="nav-link active" href="{{ route('shelters.animal_groups.animal_items.show', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">{{ $animalItem->animal->name }} - {{ $animalItem->animal->latin_name }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Dokumentacija jedinke</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_care_end.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Završetak skrbi</a>
    </li>
  </ul>

  <div class="row mt-4">
    <div class="col-md-5">
      <div class="card">
        <div class="card-body">
          <div class="row inbox-wrapper">
        
            <div class="col-lg-12 email-content">
              <div class="email-inbox-header">
                <div class="row justify-content-between">           
                    <div class="email-title mb-2 mb-md-0"> Opis postupanja u oporavilištu</div>  
                    <div>
                    <a href="{{ route('animal_items.animal_item_logs.create', $animalItem->id) }}" type="button" class="btn btn-primary btn-xs btn-icon-text">                
                          Dodaj zapis
                          <i class="btn-icon-append" data-feather="book"></i>
                        </a> 
                    </div>
                 
                </div>
              </div>
              <div class="separator--small"></div>
         
              <div class="email-list mb-4"> 
                 @foreach ($paginateLogs as $itemlLog)
                <div class="email-list-item">
           
                  <a href="{{ route('animal_items.animal_item_logs.show', [$animalItem->id, $itemlLog->id]) }}" class="email-list-detail">
                    <div>
                      <span class="from">{{  $itemlLog->log_subject }}</span>
                      <p class="msg {{ ($itemlLog->logType->type_name == 'Proširena skrb') ? 'text-danger' : '' }}">{{ $itemlLog->logType->type_name }} </p>
                    </div>
                    <div class="justify-content-between"> 
                    <span class="date {{ ($itemlLog->logType->type_name == 'Proširena skrb') ? 'text-danger' : '' }}">                        
                      {{ $itemlLog->created_at->format('d.m.Y.') }}
                    </span>
                    <a href="{{ route('animal_items.animal_item_logs.show', [$animalItem->id, $itemlLog->id]) }}" class="btn btn-warning btn-xs mt-1">
                        pregled
                     </a> 
                    </div>
                  </a>
                </div>
                @endforeach    
                         
              </div>
              {{ $paginateLogs->links() }}
            </div>
          </div>
          
        </div>
      </div>
    </div>
  
    <div class="col-md-7 grid-margin">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Informacije</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Akcije postupanja</a>
        </li>
      </ul>
      <div class="tab-content border border-top-0" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div><h6 class="card-title">Podaci o zaprimanju</h6> </div> 
                <a href="{{ route('shelters.animal_groups.animal_items.edit', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" class="btn btn-primary btn-icon-text btn-sm" type="button">
                  Izmjeni
                  <i class="btn-icon-append" data-feather="box"></i>
                </a>
              </div> 
              @if($msg = Session::get('update_animal_item'))
              <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
              @endif       
                  <div class="row">
                    <div class="col-md-4">    
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
                    </div> 
                    <div class="col-md-4 ">
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Razred: </label>
                        <p class="text-muted">{{ $animalItem->animal->animalCategory->animalSystemCategory->latin_name ?? '' }}</p>
                      </div>

                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Porodica: </label>
                        <p class="text-muted">{{ $animalItem->animal->animalCategory->latin_name ?? '' }}</p>
                      </div>  
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Red:</label>
                        <p class="text-muted">{{ $animalItem->animal->animalCategory->animalOrder->order_name ?? '' }}</p>
                      </div>  
                    
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hibernacija:</label>
                        <p class="text-info">Ne</p>
                      </div>
                  </div>   
                  <div class="col-md-4">
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Veličina:</label>
                      <p class="text-muted">{{ $animalItem->animalSizeAttributes->name ?? '' }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dob Jedinke:</label>
                      <p class="text-muted">{{ $animalItem->animal_age ?? '' }}</p>
                    </div> 
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Spol:</label>
                      <p class="text-muted">{{ $animalItem->animal_gender ?? '' }}</p>
                    </div>  
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Šifra jedinke:</label>
                      <p class="text-muted">{{ $animalItem->animal_code ?? '' }}</p>
                    </div>    
                </div>              
              </div>
            </div>
          </div><!-- end card -->
        </div><!--  end TAB -->
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Akcije postupanja</h6> 
              <form action="/animalItem/update/{{$animalItem->id}}" method="POST">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" id="hib_est_from_to">
                            <label>Hibernacija/estivacija</label>
                            <div class="d-flex">
                                <div class="input-group date datepicker" id="datePickerExample">
                                  <input type="text" name="hib_est_from" class="form-control hib_est_from" value="{{ $animalItem->dateRange->hibern_start }}">
                                  <span class="input-group-addon">
                                      <i data-feather="calendar"></i>
                                  </span>
                                </div>
                                <div class="input-group date datepicker" id="datePickerExample">
                                  <input type="text" name="hib_est_to" class="form-control hib_est_to" value="{{ $animalItem->dateRange->hibern_end }}">
                                  <span class="input-group-addon">
                                      <i data-feather="calendar"></i>
                                  </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="period">
                            <label>Razdoblje provođenja proširene skrbi <strong>(ostalo {{-- {{  $totalDays }} --}} dana)</strong></label>
                           {{--  @if ($totalDays != 0) --}}
                            <div class="d-flex">
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="full_care_start" class="form-control full_care_start">
                                    <span class="input-group-addon">
                                        <i data-feather="calendar"></i>
                                    </span>
                                </div>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="full_care_end" class="form-control full_care_end">
                                    <span class="input-group-addon">
                                        <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
                           {{--  @endif --}}
                        </div>
                      </div>       
                  </div> 
    
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Promjena Solitarna ili Grupa</label>
                        <select class="form-control" name="solitary_or_group_type" id="">
                          <option value="">---</option>
                          <option value="Grupa">Grupa</option>
                          <option value="Solitarno">Solitarno</option>
                        </select>     
                    </div> 
                  </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="">Datum</label>
                        <div class="input-group date datepicker" id="datePickerExample">          
                          <input type="text" name="solitary_or_group_end" class="form-control end_date" >
                            <span class="input-group-addon">
                              <i data-feather="calendar"></i>
                            </span>
                        </div>
                      </div>
                    </div>
                </div>
    
                <button type="submit" id="submit" class="btn btn-primary mr-2 mt-3">Ažuriraj</button>
              </form>
            </div>
          </div>
        </div><!-- end TAB -->
      </div><!-- TAB container -->
    </div>      
  </div>

 {{--  <div class="row">
    <div class="col-md-6">
     
      
       
   
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div><h6 class="card-title">Akcije postupanja</h6> </div> 
          </div> 
          @if($msg = Session::get('update_animal_item'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif        
            <div class="row">                 
      
              <div class="col-md-4 grid-margin">          
                <div class="bordered-group mt-2">
                  <label class="tx-11  mb-0 text-uppercase">Status - Solitarno/Grupa:</label>
                  <p class="text-warning text-uppercase pt-3 pb-3">{{ $animalItem->solitary_or_group ?? '' }}</p>
                  <a href="#" type="button" class="btn btn-primary btn-xs">
                    Promjena
                  </a> 

                </div>             
              </div> 
              <div class="col-md-4 grid-margin">
                <div class="bordered-group mt-2">
                  <label class="tx-11  mb-0 text-uppercase">Hibernacija:</label>
                  <p class="text-info text-uppercase pt-3 pb-3">NE</p>
                  <a href="#" type="button" class="btn btn-primary btn-xs">
                    Promjena
                  </a> 

                </div> 
              </div>  

              <div class="col-md-4 grid-margin">
                <div class="bordered-group mt-2">
                  <label class="tx-11  mb-0 text-uppercase">Proširena skrb:</label>
                  <p class="text-danger text-uppercase pt-3 pb-3">NE</p>
                  <a href="#" type="button" class="btn btn-primary btn-xs">
                    Promjena
                  </a> 

                </div> 
              </div>  
            </div>     
        </div>
      </div> 
    </div>
  </div> --}}

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/lightbox2/lightbox.min.js') }}"></script> 
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
@endpush