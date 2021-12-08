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
       <a href="{{ route('shelters.animal_groups.animal_items.show', [$shelter->id, $animalGroup->id, $animalItem->id]) }}" type="button" class="btn btn-primary btn-sm btn-icon-text">
          Povratak na popis
          <i class="btn-icon-append" data-feather="clipboard"></i>
        </a> 
    </div>
  </div>

  <ul class="nav shelter-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.show', [$shelter->id, $animalGroup->id, $animalItem->id]) }}">{{ $animalItem->animal->name }} - {{ $animalItem->animal->latin_name }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$shelter->id, $animalGroup->id, $animalItem->id]) }}">Dokumentacija</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">Eutanazija</a>
    </li>
  </ul>

  <div class="d-flex align-items-center justify-content-between">
    <div><h6 class="card-description">Dokumentacija jedinke</h6> </div> 
    @if($msg = Session::get('store_docs'))
    <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
    @endif
    @if($animalItem->animalDocumentation)
    <div> 
      <a href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.edit', 
      [$animalItem->shelter_id, $animalItem->animal_group_id,
       $animalItem->id, $animalItem->animalDocumentation->id]) }}" type="button" class="btn btn-warning btn-sm btn-icon-text">
        Izmjeni
         <i class="btn-icon-append" data-feather="edit"></i>
       </a> 

       <a id="deleteDoc" href="#" type="button" class="btn btn-danger btn-sm btn-icon-text" 
       data-shelter-id={{ $animalItem->shelter_id }} data-group-id={{$animalItem->animal_group_id }}
       data-item-id={{  $animalItem->id }} data-documentation-id={{ $animalItem->animalDocumentation->id }}>
        Brisanje
         <i class="btn-icon-append" data-feather="edit"></i>
       </a> 
    </div>
        @else
        <div> 
          <a href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.create', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" type="button" class="btn btn-warning btn-sm btn-icon-text">
            Kreiraj dokumentaciju
             <i class="btn-icon-append" data-feather="edit"></i>
           </a> 
        </div>
    @endif
  </div> 

  <div class="row mt-4">
    <div class="col-5 col-md-3">
      <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
        <a class="nav-link active" id="v-found-tab" data-toggle="pill" href="#v-found" role="tab" aria-controls="v-found" aria-selected="true">Stanje u trenutku pronalaska</a>
        <a class="nav-link" id="v-recive-tab" data-toggle="pill" href="#v-recive" role="tab" aria-controls="v-recive" aria-selected="false">Stanje u trenutku zaprimanja</a>
        <a class="nav-link" id="v-reason-tab" data-toggle="pill" href="#v-reason" role="tab" aria-controls="v-reason" aria-selected="false">Razlog zaprimanja</a>
        <a class="nav-link" id="v-founder-tab" data-toggle="pill" href="#v-founder" role="tab" aria-controls="v-founder" aria-selected="false">Nalaznik</a>
        <a class="nav-link" id="v-mark-tab" data-toggle="pill" href="#v-mark" role="tab" aria-controls="v-mark" aria-selected="false">Oznaka jedinke</a>
      </div>
    </div>
    <div class="col-7 col-md-9">
      <div class="tab-content tab-content-vertical" id="v-tabContent">
        <div class="tab-pane fade show active" id="v-found" role="tabpanel" aria-labelledby="v-found-tab">
          <div class="card">
            <div class="card-body">
              
                <div class="d-flex align-items-center justify-content-between">
                  <div><h6 class="card-description">Stanje u trenutku pronalaska</h6> </div> 
                  <div>     
                  </div>
                </div>     
                @if($msg = Session::get('update_animal_item'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif      
                  <div class="row">
                    <div class="col-md-12 grid-margin">  
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stanje jedinke: </label>
                        <p class="text-muted">{{ $animalItem->animalDocumentation->stateFound->name ?? '' }}</p>
                      </div> 
                      <div class="separator separator--small"></div> 
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                          <p class="text-muted">{{ $animalItem->animalDocumentation->state_found_desc ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokumentacija: </label>
                          @isset($animalItem->animalDocumentation->state_found)
                        
                          <div class="bordered-group mt-2">
                            <div class="latest-photos d-flex">
                              @foreach ($animalItem->animalDocumentation->getMedia('state_found_file') as $media)
                                @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))
                                <div class="photo-item d-flex flex-column">
                                  <a href="{{ $media->getUrl() }}" data-lightbox='image-{{ $media->id }}'>
                                    <figure>
                                      <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                    </figure>
                                  </a>
                                </div>          
                                @else
                              <div class="document-item d-flex flex-column">
                                <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>  
                              </div>                  
                              @endif                                  
                              @endforeach
                            </div>
                          </div>
                          
                        @endisset
                        </div>
                    </div>                   
                  </div>   
              
            </div>
          </div>            
        </div>
          <div class="tab-pane fade" id="v-recive" role="tabpanel" aria-labelledby="v-recive-tab">
            <div class="card">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div><h6 class="card-description">Stanje u trenutku zaprimanja</h6> </div> 
                    <div>      
                    </div>
                  </div> 
                  @if($msg = Session::get('update_animal_item'))
                  <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                  @endif      
                    <div class="row">
                      <div class="col-md-12 grid-margin">  
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stanje jedinke: </label>
                          <p class="text-muted">{{ $animalItem->animalDocumentation->stateRecived->name ?? '' }}</p>
                        </div> 
                        <div class="separator separator--small"></div> 
                          <div class="mt-2">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                            <p class="text-muted">{{ $animalItem->animalDocumentation->state_recive_desc ?? '' }}</p>
                          </div>
                          <div class="mt-2">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokumentacija: </label>
                            @isset($animalItem->animalDocumentation->state_recive)               
                            <div class="bordered-group mt-2">
                              <div class="latest-photos d-flex">
                                @foreach ($animalItem->animalDocumentation->getMedia('state_receive_file') as $media)
                                  @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))
                                  <div class="photo-item d-flex flex-column">
                                    <a href="{{ $media->getUrl() }}" data-lightbox='image-{{ $media->id }}'>
                                      <figure>
                                        <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                      </figure>
                                    </a>
                                  </div>          
                                  @else
                                  <div class="document-item d-flex flex-column">
                                    <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>  
                                  </div>                  
                                  @endif     
                                @endforeach
                              </div>
                            </div>
                            
                          @endisset
                          </div>
                      </div>                   
                  </div>        
              </div>
            </div>      
          </div><!-- END TAB -->
          <div class="tab-pane fade" id="v-reason" role="tabpanel" aria-labelledby="v-reason-tab">
            <div class="card">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div><h6 class="card-description">Razlog zaprimanja</h6> </div>        
                  </div> 
                  @if($msg = Session::get('update_animal_item'))
                  <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                  @endif      
                  <div class="row">
                    <div class="col-md-12 grid-margin">  
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stanje jedinke: </label>
                        <p class="text-muted">{{ $animalItem->animalDocumentation->stateReason->name ?? '' }}</p>
                      </div> 
                      <div class="separator separator--small"></div> 
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                          <p class="text-muted">{{ $animalItem->animalDocumentation->state_reason_desc ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokumentacija: </label>
                          @isset($animalItem->animalDocumentation->state_reason)
                          
                          <div class="bordered-group mt-2">
                            <div class="latest-photos d-flex">
                              @foreach ($animalItem->animalDocumentation->getMedia('state_reason_file') as $media)
                              @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))
                                  <div class="photo-item d-flex flex-column">
                                    <a href="{{ $media->getUrl() }}" data-lightbox='image-{{ $media->id }}'>
                                      <figure>
                                        <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                      </figure>
                                    </a>
                                  </div>          
                                  @else
                                  <div class="document-item d-flex flex-column">
                                    <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>  
                                  </div>                  
                                  @endif             
                              @endforeach
                            </div>
                          </div>
                          
                        @endisset
                        </div>
                    </div>                   
                  </div>              
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="v-founder" role="tabpanel" aria-labelledby="v-founder-tab">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">
                    <div><h6 class="card-description">Nalaznik</h6> </div>  
                    <div class="row">
                      <div class="col-md-12 grid-margin">  
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Nalaznik: </label>
                          <p class="text-muted">{{ $animalItem->founder->name }} - {{ $animalItem->founder->service }}</p>
                        </div>
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Napomena nalaznika: </label>
                          <p class="text-muted">{{ $animalItem->founder_note }}</p>
                        </div>
                          <div class="mt-2">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokumentacija: </label>
                            @isset($animalItem->animalDocumentation->state_reason)                 
                            <div class="bordered-group mt-2">
                              <div class="latest-photos d-flex">
                                @foreach ($animalItem->animalDocumentation->getMedia('state_reason_file') as $media)                 
                                  <a href="{{ $media->getUrl() }}" data-lightbox='image-{{ $media->id }}'>
                                    {{ $media->name }}
                                  </a>                    
                                @endforeach
                              </div>
                            </div>               
                            @endisset
                          </div>
                      </div>                   
                  </div>  
                  </div>
                </div> 
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-body">       
                      <div class="d-flex align-items-center justify-content-between">
                        <div><h6 class="card-description">Okolnosti pronalaska</h6> </div> 
                        <div>     
                        </div>
                      </div>     
                      @if($msg = Session::get('update_animal_item'))
                      <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                      @endif      
                        <div class="row">
                          <div class="col-md-12 grid-margin">  
                            <div class="separator separator--small"></div> 
                              <div class="mt-2">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                                <p class="text-muted">{{ $animalItem->animal_found_note ?? '' }}</p>
                              </div>
                          </div>                   
                        </div>                      
                  </div>
                </div>
              </div>
            </div>
                                 
          </div><!-- END TAB -->
          <div class="tab-pane fade" id="v-mark" role="tabpanel" aria-labelledby="v-mark-tab">
            <div class="card">
              <div class="card-body">
                  <div class="d-flex align-items-center justify-content-between">
                    <div><h6 class="card-description">Oznaka jedinke</h6> </div> 
                    <div>      
                    </div>
                  </div>      
                    <div class="row">
                      <div class="col-md-12 grid-margin">  
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Tip oznake: </label>
                          @isset($animalItem->animalDocumentation->animalMark)
                          <p class="text-muted">{{ $animalItem->animalDocumentation->animalMark->animalMarkType->name  ?? '' }} 
                            ({{ $animalItem->animalDocumentation->animalMark->animalMarkType->desc }})
                          </p>
                          @endisset 
                        </div> 
                        <div class="separator separator--small"></div> 
                          <div class="mt-2">
                            @isset($animalItem->animalDocumentation->animalMark->animal_mark_note)
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv oznake: </label>
                            <p class="text-muted">{{ $animalItem->animalDocumentation->state_recive_desc ?? '' }}</p>
                            @endisset    
                          </div>        
                         
                          <div class="mt-2">
                            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokumentacija: </label>                                 
                            <div class="bordered-group mt-2">
                              <div class="latest-photos d-flex">
                                @if (!empty($animalItem->animalDocumentation))
                                  @foreach ($animalItem->animalDocumentation->getMedia('animal_mark_photos') as $media)      
                                    @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))
                                    <div class="photo-item d-flex flex-column">
                                      <a href="{{ $media->getUrl() }}" data-lightbox='image-{{ $media->id }}'>
                                        <figure>
                                          <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                        </figure>
                                      </a>
                                    </div>          
                                    @else
                                    <div class="document-item d-flex flex-column">
                                      <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>  
                                    </div>                  
                                    @endif                       
                                  @endforeach  
                                @endif
                                                     
                              </div>
                            </div>
                          </div>
                      </div>                   
                  </div>               
              </div>
            </div>
          </div><!-- END TAB -->
        </div><!-- END TAB CONTAINER -->
    
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

  <script>
      $(function() {
         
                 
            function stateFoundScript() {
              $("#stateFoundFile").fileinput({
              language: "cr",
              //required: true,
              showPreview: false,
              showUpload: false,
              showCancel: false,
              allowedFileExtensions: ["pdf", "jpg", "png", 'doc', 'docx'],
              elErrorContainer: '#error_euthanasia_file',
              msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
               });
            }

            function stateReciveScript() {
              $("#stateRecivedFile").fileinput({
              language: "cr",
              //required: true,
              showPreview: false,
              showUpload: false,
              showCancel: false,
              allowedFileExtensions: ["pdf", "jpg", "png", 'doc', 'docx'],
              elErrorContainer: '#error_euthanasia_file',
              msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
               });
            };

          // Delete doc
          $('body').on('click', '#deleteDoc', function() {

          var documentation_id = $(this).data('documentation-id');
          var shelter_id = $(this).data('shelter-id');
          var animal_item_id = $(this).data('item-id');
          var group_id = $(this).data('group-id');

            Swal.fire({
                title: "Brisanje?",
                text: "Potvrdite ako ste sigurni za brisanje!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Da, brisanje!",
                cancelButtonText: "Ne, odustani!",
                reverseButtons: !0
            }).then(function (e) {

            if (e.value === true) {
                            
                $.ajax({
                    type: 'DELETE',
                    url: "/shelters/"+shelter_id+"/animal_groups/"+group_id+"/animal_items/"+animal_item_id+"/animal_item_documentations/"+documentation_id,
                    data: {_token: '{{csrf_token()}}'},
                    dataType: 'JSON',
                    success: function (results) {
                      location.reload();
                    }
                });

              } else {
                e.dismiss;
              }

              }, function (dismiss) {
              return false;
              })
          });

      })
  </script>

  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush