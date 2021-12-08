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
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Dokumentacija</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">Eutanazija</a>
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
                    <div class="email-title mb-2 mb-md-0"><span class="icon"><i data-feather="book"></i></span> Postupak postupanja u oporavilištu</div>  
                    <div>
                    <a href="{{ route('animal_items.animal_item_logs.create', $animalItem->id) }}" type="button" class="btn btn-primary btn-sm btn-icon-text">                
                          Dodaj zapis
                          <i class="btn-icon-append" data-feather="book"></i>
                        </a> 
                    </div>
                 
                </div>
              </div>
              <div class="separator--small"></div>
         
              <div class="email-list"> 
                 @foreach ($animalItem->animalItemLogs as $itemlLog)
                <div class="email-list-item">
           
                  <a href="{{ route('animal_items.animal_item_logs.show', [$animalItem->id, $itemlLog->id]) }}" class="email-list-detail">
                    <div>
                      <span class="from">{{  $itemlLog->log_subject }}</span>
                      <p class="msg">{{ $itemlLog->logType->type_name }} </p>
                    </div>
                    <div class="justify-content-between"> 
                    <span class="date">                        
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
            </div>
          </div>
          
        </div>
      </div>
    </div>
  
    <div class="col-md-7 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div><h6 class="card-title">Podaci o zaprimanju</h6> </div> 
            <a href="{{ route('shelters.animal_groups.animal_items.edit', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" class="btn btn-primary btn-icon-text btn-sm" type="button">
              Izmjeni podatke
              <i class="btn-icon-append" data-feather="box"></i>
            </a>
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
            <div class="row">
              <div class="separator"></div>
            </div> 
            <div class="row">                 
      
              <div class="col-md-4 grid-margin">  
                
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Status jedinke:</label>
                  <p class="text-muted">U oporavilištu</p>
                
                <div class="mt-2">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Način Držanja:</label>
                  <p class="text-muted">{{ $animalItem->solitary_or_group ?? '' }}</p>
                </div>             
              </div> 
              <div class="col-md-4 grid-margin">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Oznaka jedinke:</label>
                @if (!empty($animalItem->animalDocumentation->animalMark))
                  <p class="text-muted">{{ $animalItem->animalDocumentation->animalMark->animalMarkType->name ?? '' }}</p>
                @endif
                <div class="mt-2">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv oznake:</label>
                  @if (!empty($animalItem->animalDocumentation->animalMark))
                    <p class="text-muted">{{ $animalItem->animalDocumentation->animalMark->animal_mark_note ?? '' }}</p>
                  @endif
                </div>
              </div>  
              <div class="col-md-4 grid-margin">
               {{--  @foreach ($animalItem->animalMarks->media as $thumbnail) 
                
                  <a href="{{ $thumbnail->getUrl() }}" data-lightbox="equipment">
                  <figure>
                    <img class="img-fluid" src="{{ $thumbnail->getUrl() }}" alt="">
                  </figure>
                  </a>
                 
                @endforeach --}}
              </div>
            </div>     
        </div>
      </div>    
    </div>      
  </div>

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