@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
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
    </div>
  </div>
  
  <ul class="nav shelter-nav">
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('shelters.animal_groups.animal_items.show', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">{{ $animalItem->animal->name }} - {{ $animalItem->animal->latin_name }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Dokumentacija jedinke</a>
    </li>

    @role('Administrator|Oporavilište')
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_care_end.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Završetak skrbi</a>
    </li>
    @endrole

  </ul>

  @if($msg = Session::get('care_end'))
  <div id="successMessage" class="alert alert-warning"> {{ $msg }}</div>
  @endif 
  
  @if($izvj = Session::get('izvj'))
  <div id="successMessage" class="alert alert-warning"> {{ $izvj }}</div>
  @endif 

  <div class="row mt-4">
    <div class="col-md-5">
      <div class="card">
        <div class="card-body">
          <div class="row inbox-wrapper">
        
            <div class="col-lg-12 email-content">
              <div class="email-inbox-header">
                <div class="row justify-content-between">           
                    <div class="email-title mb-2 mb-md-0"> Opis postupanja u oporavilištu</div>
                    
                    @can('create')
                    <div>
                      <a href="{{ route('animal_items.animal_item_logs.create', $animalItem->id) }}" type="button" class="btn btn-primary btn-xs">                
                          Dodaj zapis
                      </a> 
                    </div>
                    @endcan
                 
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
                    <a href="{{ route('animal_items.animal_item_logs.show', [$animalItem->id, $itemlLog->id]) }}" class="btn btn-secondary btn-xs mt-1">
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
          <a class="nav-link {{ Session::get('error') ? '' : 'active' }}" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="{{ Session::get('error') ? 'false' : 'true' }}">Informacije</a>
        </li>
        @role('Administrator|Oporavilište')
          @if ($animalItem->animal_item_care_end_status == true)
            @if ($animalItem->animal->animalType->first()->type_code != 'IJ')
              <li class="nav-item">
                <a class="nav-link {{ Session::get('error') ? 'active' : '' }}" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="{{ Session::get('error') ? 'true' : 'false' }}">Akcije postupanja</a>
              </li>
            @endif
          @endif
        @endrole
      </ul>

      <div class="tab-content  border-top-0" id="myTabContent">
        <div class="tab-pane fade {{ Session::get('error') ? '' : 'show active' }}" id="home" role="tabpanel" aria-labelledby="home-tab">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">
                <div><h6 class="card-title">Podaci o zaprimanju</h6> </div> 

                <div>
                  @can('create', 'edit')
                    @if ($animalItem->animal->animalType->first()->type_code == 'ZJ')
                      @if ($animalItem->full_care_status == 1)
                        <a href="javascript:void(0)" data-id="0" 
                          class="btn {{ $animalItem->animal_item_care_end_status == 1 ? 'fullcare btn-danger' : 'btn-light' }} btn-xs" 
                          type="button">
                          Onemogući proširenu skrb
                        </a>
                      @else
                        <a href="javascript:void(0)" data-id="1" 
                          class="btn {{ $animalItem->animal_item_care_end_status == 1 ? 'fullcare btn-warning' : 'btn-light' }} btn-xs" 
                          type="button">
                          Omogući proširenu skrb
                        </a>
                      @endif
                    @endif
                    
                    <a href="{{ route('shelters.animal_groups.animal_items.edit', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" class="btn btn-primary btn-xs" type="button">
                      Izmjeni podatke
                    </a>
                  @endcan
                </div>

              </div> 
              @if($msg = Session::get('update_animal_item'))
              <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
              @endif       

                <div class="row">
                  <div class="col-md-4">
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Interni naziv: </label>
                      <p class="text-muted">{{ $animalItem->interni_naziv }}</p>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-4">    
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hrvatski naziv: </label>
                      <p class="text-muted">{{ $animalItem->animal->name }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Engleski naziv: </label>
                      <p class="text-muted">{{ $animalItem->animal->english_name ?? '' }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Latinski naziv:</label>
                      <p class="text-muted">{{ $animalItem->animal->latin_name ?? ''  }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Datum pronalaska:</label>
                      <p class="text-info">{{ isset($animalItem->animal_date_found) ? $animalItem->animal_date_found->format('d.m.Y') : '' }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Način držanja:</label>
                      <p class="text-warning">{{ $animalItem->solitary_or_group ?? '' }}</p>
                    </div>

                    @if (!empty($animalItemShelter))
                    {{-- Ako je poslano u oporavilište --}}
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Poslano u oporavilište:</label>
                      <p class="text-muted">
                        @role('Administrator')
                        <a href="{{ route('shelters.animal_groups.animal_items.show', [$animalItemShelter->shelter->id, $animalItemShelter->animalGroup->id, $animalItemShelter->id]) }}" target="_blank">
                          {{ $animalItemShelter->shelter->name }}
                        </a>
                        @elserole('Oporavilište')
                        {{ $animalItemShelter->shelter->name }}
                        @endrole
                      </p>
                    </div>
                    {{-- Ako je poslano u oporavilište --}}
                    @endif

                    @if (!empty($animalItemShelterdoslo))
                    {{-- Ako je stigla iz drugog oporavilišta --}}
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Došlo iz oporavilišta:</label>
                      <p>
                        <a href="javascript:void(0)" data-toggle="modal" data-target=".bd-example-modal-lg">
                          {{ $animalItemShelterdoslo->shelter->name }}
                        </a>
                      </p>
                    </div>
                    {{-- Ako je stigla iz drugog oporavilišta --}}
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                    
                          <div class="modal-header">
                            <h5 class="modal-title h4" id="myLargeModalLabel">{{ $animalItemShelterdoslo->shelter->name }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            
                            <div class="row">
                              <div class="col-md-4">
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Hrvatski naziv: </label>
                                  <p class="text-muted">{{ $animalItemShelterdoslo->animal->name }}</p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Engleski naziv: </label>
                                  <p class="text-muted">{{ $animalItemShelterdoslo->animal->english_name ?? '' }}</p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Latinski naziv:</label>
                                  <p class="text-muted">{{ $animalItemShelterdoslo->animal->latin_name ?? ''  }}</p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Šifra jedinke:</label>
                                  <p class="text-muted">{{ $animalItemShelterdoslo->animal_code  }}</p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Datum pronalaska:</label>
                                  <p class="text-info">{{ isset($animalItemShelterdoslo->animal_date_found) ? $animalItemShelterdoslo->animal_date_found->format('d.m.Y') : '' }}</p>
                                </div>

                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Datum završetka skrbi:</label>
                                  <p class="text-info">
                                    {{ isset($animalItemShelterdoslo->dateRange->end_date) ? $animalItemShelterdoslo->dateRange->end_date->format('d.m.Y') : '' }}
                                  </p>
                                </div>

                              </div>
                              <div class="col-md-6">
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Okolnosti i način pronalaska životinje: </label>
                                  <p class="text-muted">{{ $animalItemShelterdoslo->animal_found_note }}</p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Lokacija pronalska: </label>
                                  <p class="text-muted">{{ $animalItemShelterdoslo->location }}</p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Način držanja:</label>
                                  <p class="text-warning">{{ $animalItemShelterdoslo->solitary_or_group ?? '' }}</p>
                                </div>

                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stanje u kojem je životinja pronađena:</label>
                                  <p class="text-muted">
                                  {{ $animalItemShelterdoslo->animalDocumentation->stateFound->name ?? '' }}
                                  </p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stanje životinje u trenutku zaprimanja u oporavilište:</label>
                                  <p class="text-muted">
                                    {{ $animalItemShelterdoslo->animalDocumentation->stateRecived->name ?? '' }}
                                  </p>
                                </div>
                                <div class="mt-2">
                                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Razlog zaprimanja životinje u oporavilište:</label>
                                  <p class="text-muted">
                                    {{ $animalItemShelterdoslo->animalDocumentation->stateReason->name ?? '' }}
                                  </p>
                                </div>
                                
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                    @endif

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
                        @if ( $hibern )
                          <p class="text-info">DA</p>
                          
                        @else
                          <p class="text-danger">NE</p>
                        @endif
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
          @if ($animalItem->animal_item_care_end_status == false)
          <div class="card mt-3">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between">         
                <div class="email-title mb-2 mb-md-0"> <h6 class="card-title">Status Skrbi</h6></div>  
                <div>
                <a href="{{ route('shelters.animal_groups.animal_items.animal_item_care_end.index', 
                  [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" 
                  type="button" class="btn btn-primary btn-xs">                
                  Pregled cijene skrbi                
                </a> 
                </div>
             
              </div>
              <div class="row">
                <div class="col-md-6">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="text-danger">ZAVRŠENA SKRB</span></li>
                    <li class="list-group-item">Razlog prestanka skrbi: <span class="text-warning">{{ $animalItem->careEnd->careEndType->name ?? '' }}</span></li>
                    <li class="list-group-item">Trajanje skrbi: <span class="text-warning">{{ $date->start_date->diffInDays($date->end_date) }} dan/a</span></li>
                     
                  </ul>
                </div>
                <div class="col-md-6">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><p class="text-light">Početak skrbi: <span class="text-light">{{ $animalItem->dateRange->start_date->format('d.m.Y') }}</span></p></li>
                    <li class="list-group-item"><p class="text-light">Kraj skrbi: <span class="text-light">{{ $animalItem->dateRange->end_date->format('d.m.Y') }}</span></p></li>
                    
                    <li class="list-group-item">Ukupna cijena skrbi: 
                      <span class="text-info"> 
                        @if (!empty($animalItem->dateRange->end_date))
                          {{ $price->total_price ? $price->total_price . 'kn' : '0kn' }}
                        @endif
                      </span>
                    </li>       
                  </ul>
                </div>
              </div>
        
            </div>
          </div>
          @endif
        </div><!--  end TAB -->

        @if ($animalItem->animal_item_care_end_status == true)
        <div class="tab-pane fade {{ Session::get('error') ? 'show active' : '' }}" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Akcije postupanja</h6>

              @if($msg = Session::get('error'))
                <div id="dangerMessage" class="alert alert-danger"> {{ $msg }}</div>
              @endif

              <form action="/animalItem/update/{{$animalItem->id}}" method="POST" autocomplete="off">
                @csrf
                @method('POST')

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Promjena Solitarna ili Grupa</label>
                        <select class="form-control" name="solitary_or_group_type" id="">
                          <option value="">---</option>
                          @if ($animalItem->solitary_or_group == 'Grupa')
                            <option value="Solitarno">Solitarno</option>
                          @else
                            <option value="Grupa">Grupa</option>
                          @endif
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

                @foreach ($arrayAnimalForFullCare as $ii)
                  @if($animalItem->animal_id == $ii)
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group" id="period">
                              <label>Razdoblje provođenja proširene skrbi <strong class="text-warning">(ostalo {{  $totalDays }} dan/a)</strong></label>
                              @if ($totalDays != 0)
                              <div class="d-flex">
                                  <div class="input-group date datepicker" id="datePickerExample">
                                      <input type="text" name="full_care_start" class="form-control full_care_start"
                                      value="{{ isset($lastFullCare->start_date) ? $lastFullCare->start_date->format('d/m/Y') : null }}">
                                      <span class="input-group-addon">
                                          <i data-feather="calendar"></i>
                                      </span>
                                  </div>
                                  <div class="input-group date datepicker" id="datePickerExample">
                                      <input type="text" name="full_care_end" class="form-control full_care_end"
                                      value="{{ isset($lastFullCare->end_date) ? $lastFullCare->end_date->format('d/m/Y') : null }}">
                                      <span class="input-group-addon">
                                          <i data-feather="calendar"></i>
                                      </span>
                                  </div>
                              </div>
                              @endif
                          </div>
                      </div>       
                  </div>
                  @endif
                @endforeach

                @if ($animalItem->animal->animalType->first()->type_code == 'ZJ')
                  @if ($animalItem->full_care_status == 1)
                    <div class="row">
                      <div class="col-md-12">
                          <div class="form-group" id="period">
                              <label>Razdoblje provođenja proširene skrbi <strong class="text-warning">(ostalo {{  $totalDays }} dan/a)</strong></label>
                              @if ($totalDays != 0)
                              <div class="d-flex">
                                  <div class="input-group date datepicker" id="datePickerExample">
                                      <input type="text" name="full_care_start" class="form-control full_care_start"
                                      value="{{ isset($lastFullCare->start_date) ? $lastFullCare->start_date->format('d/m/Y') : null }}">
                                      <span class="input-group-addon">
                                          <i data-feather="calendar"></i>
                                      </span>
                                  </div>
                                  <div class="input-group date datepicker" id="datePickerExample">
                                      <input type="text" name="full_care_end" class="form-control full_care_end"
                                      value="{{ isset($lastFullCare->end_date) ? $lastFullCare->end_date->format('d/m/Y') : null }}">
                                      <span class="input-group-addon">
                                          <i data-feather="calendar"></i>
                                      </span>
                                  </div>
                              </div>
                              @endif
                          </div>
                      </div>       
                    </div>
                  @endif
                @endif

                <div class="form-group" id="hib_est_from_to">
                  <label>Hibernacija/estivacija</label>
                  <div class="d-flex">
                      <div class="input-group date datepicker" id="datePickerExample">
                        <input type="text" name="hib_est_from" class="form-control hib_est_from" 
                        value="{{ !empty($date->hibern_start) ? $date->hibern_start->format('d/m/Y') : null }}">
                        <span class="input-group-addon">
                            <i data-feather="calendar"></i>
                        </span>
                      </div>
                      <div class="input-group date datepicker" id="datePickerExample">
                        <input type="text" name="hib_est_to" class="form-control hib_est_to" 
                        value="{{ !empty($date->hibern_end) ? $date->hibern_end->format('d/m/Y') : null }}">
                        <span class="input-group-addon">
                            <i data-feather="calendar"></i>
                        </span>
                      </div>
                  </div>
                </div>       

                <button type="submit" id="submit" class="btn btn-primary mr-2 mt-3">Ažuriraj</button>
              </form>
            </div>
          </div>
        </div><!-- end TAB -->
        @endif
        
        @if ($animalItem->animal_item_care_end_status == true)
        <div class="card mt-2">
          <div class="card-body">
            <h6 class="card-title">Popis akcija</h6>
            <div class="row">          
              @if (!empty($startSolitaryGroup))
              <div class="col-md-4">
                <div class="mt-2">
                  <label>Trenutni status: {{ $startSolitaryGroup->solitary_or_group }}</label>
                  <p class="text-muted">Početak {{ $startSolitaryGroup->start_date->format('d.m.Y') }}</p>
                </div>
              </div>
              @endif
              
              @if ( $hibern ) 
                <div class="col-md-4">
                  <div class="mt-2">
                    <label for="">Hibernacija</label>
                    <p class="text-muted">Početak: {{ $hibern->hibern_start->format('d.m.Y') ?? '' }}</p>
                    <p class="text-muted">Kraj: {{ $hibern->hibern_end->format('d.m.Y') ?? '' }}</p>
                  </div>
                </div>
              @endif   
              @if (!empty($fullCare->first())) 
                <div class="col-md-4">        
                  <div class="mt-2">
                    <label class="tx-11 font-weight text-danger mb-0 text-uppercase">Proširena skrb:</label>
                    @if (!empty($lastFullCare))
                      <p class="text-muted">Početak: {{ $lastFullCare->start_date->format('d.m.Y') }}</p>
                    @endif

                    <p class="text-muted">
                      Početak, kraj: 
                      @foreach ($fullCare as $full)
                        @if (!empty($full->end_date))
                          <p class="text-muted">
                            {{ $full->start_date->format('d.m.Y') .' - '. $full->end_date->format('d.m.Y') }}
                            ({{ $full->days }} dan/a)
                          </p>
                        @endif
                      @endforeach
                    </p>
                  </div>                          
              </div>
              @endif


              @if (!empty($allSolitaryGroup))
              <div class="col-md-4">
                <div class="mt-2">
                  @foreach ($allSolitaryGroup as $item => $value)
                    
                    @foreach ($value as $v)
                    <div class="mb-2">
                      <label class="mb-0">Protekli status: {{ $item }}</label>
                      <p class="text-muted">Početak {{ $v->start_date->format('d.m.Y') }}</p>
                      <p class="text-muted">Kraj {{ $v->end_date->format('d.m.Y') }}</p>
                    </div>
                    @endforeach
                  @endforeach
                </div>
              </div>
              @endif         
            </div>
          </div>
        </div>
        @endif
               
      </div><!-- TAB container -->
    </div>      
  </div>

  @if ($animalItem->animal_item_care_end_status == false)
  <div class="row">
    <div class="col-md-5 stretch-card">

      

    </div>
    <div class="col-md-7">

      
    </div>
  </div>
  @endif

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
  <script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/lightbox2/lightbox.min.js') }}"></script> 
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.hr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
    $(function(){

      if($('div#datePickerExample').length) {
          $('div#datePickerExample input').datepicker({
              format: "dd/mm/yyyy",
              todayHighlight: true,
              autoclose: true,
              orientation: "bottom",
              language: 'hr',
          });
          $("div#datePickerExample").find(".hib_est_from").datepicker('setDate', $("div#datePickerExample").find(".hib_est_from").val());
          $("div#datePickerExample").find(".hib_est_to").datepicker('setDate', $("div#datePickerExample").find(".hib_est_to").val());
      }

      $(".fullcare").on('click', function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('animal_item.fullcare', [$animalItem]) }}",
            method: 'POST',
            data: {
                'id': $(this).attr('data-id'),
            },
            success: function(data) {
              if(data.msg == 'success'){
                  Swal.fire(
                      'Odlično!',
                      'Zahtjev je uspješno poslan.',
                      'success'
                  ).then((result) => {
                      location.reload();
                  });
              }
            }
        });
      });

    });
  </script>
@endpush