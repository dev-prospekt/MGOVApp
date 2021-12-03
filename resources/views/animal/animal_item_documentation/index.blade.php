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
        
        <a href="/shelters/{{ $animalItem->shelter_id }}/animal_groups/{{ $animalItem->animal_group_id }}" type="button" class="btn btn-warning btn-sm btn-icon-text">
          Premještaj jedinke
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
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.show', [$shelter->id, $animalGroup->id, $animalItem->id]) }}">{{ $animalItem->animal->name }} - {{ $animalItem->animal->latin_name }}</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$shelter->id, $animalGroup->id, $animalItem->id]) }}">Dokumentacija</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="#">Eutanazija</a>
    </li>
  </ul>

  <div class="row mt-4">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div><h6 class="card-description">Okolnosti i način pronalaska</h6> </div> 
              <a href="#" class="btn btn-primary btn-icon btn-sm" type="button">
              <i class="btn-icon-append" data-feather="box"></i>
            </a> 
          </div> 
          @if($msg = Session::get('update_animal_item'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif      
            <div class="row">
              <div class="col-md-12 grid-margin">    
                  <div class="mt-2 bordered-group">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                    <p class="text-muted">{{ $animalItem->animal_found_note }}</p>
                  </div>
              </div>                   
          </div>   
        </div>
      </div>
    </div>  
    
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div><h6 class="card-description">Stanje u trenutku pronalaska</h6> </div> 
            <div>
              <button id="createStateFound" href="#" class="btn btn-primary btn-icon btn-sm" type="button" data-item-id={{ $animalItem->id }}>
                <i class="btn-icon-append" data-feather="database"></i>
              </button>
            
              @isset($animalItem->animalDocumentation->last()->state_found)
              <a href="#" class="btn btn-warning btn-icon btn-sm" type="button">
                <i class="btn-icon-append" data-feather="edit"></i>
              </a>
              <button id="deleteStateFound" href="#" class="btn btn-danger btn-icon btn-sm" type="button" data-item-id={{ $animalItem->animalDocumentation->last()->id }}>
                <i class="btn-icon-append" data-feather="trash"></i>
              </button>  
              @endisset
            
              
            </div>
          </div> 
          @if($msg = Session::get('update_animal_item'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif      
            <div class="row">
              <div class="col-md-12 grid-margin">  
                <div class="mt-2">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stanje jedinke: </label>
                  <p class="text-muted">{{ $animalItem->animalDocumentation->last()->state_found ?? '' }}</p>
                </div> 
                <div class="separator separator--small"></div> 
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                    <p class="text-muted">{{ $animalItem->animalDocumentation->last()->state_found_desc ?? '' }}</p>
                  </div>
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokumentacija: </label>
                    @isset($animalItem->animalDocumentation->last()->state_found)
                    @foreach ($animalItem->animalDocumentation->last()->getMedia('state_found_files') as $item)
                    <div class="bordered-group mt-2">
                      <div class="latest-photos">
                        @if ($item->mime_type == 'image/png' || $item->mime_type == 'image/jpg')
                          <a href="{{ $item->getUrl() }}" data-lightbox="image">
                          <figure>
                            <img class="img-fluid" src="{{ $item->getUrl() }}" alt="">
                          </figure>
                          </a>
                        
                        @else
                        <a href="{{ $item->getUrl() }}">{{ $item->name }}</a>                    
                        @endif                
                      </div>
                    </div>
                    @endforeach
                  @endisset
                  </div>
              </div>                   
          </div>   
        </div>
      </div>       
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between">
            <div><h6 class="card-description">Stanje u trenutku zaprimanja</h6> </div> 
            <div>
              <a href="#" class="btn btn-primary btn-icon btn-sm" type="button">
                <i class="btn-icon-append" data-feather="database"></i>
              </a>
              <a href="#" class="btn btn-warning btn-icon btn-sm" type="button">
                <i class="btn-icon-append" data-feather="edit"></i>
              </a>
              <a href="#" class="btn btn-danger btn-icon btn-sm" type="button">
                <i class="btn-icon-append" data-feather="trash"></i>
              </a>
            </div>
          </div> 
          @if($msg = Session::get('update_animal_item'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif      
            <div class="row">
              <div class="col-md-12 grid-margin">    
                  <div class="mt-2 bordered-group">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis: </label>
                    <p class="text-muted">{{ $animalItem->animal_found_note }}</p>
                  </div>
              </div>                   
          </div>   
        </div>
      </div>
    </div>  
                                  
  </div>
      

<div class="modal"></div>

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
          // Create 
          $("#createStateFound").click(function(e) {
                e.preventDefault();   
                var animal_item = $(this).data('item-id');
                console.log(animal_item);
                $.ajax({
                    url: "/item_state_found/"+animal_item,
                    method: 'GET',
                    success: function(result) {
                        $(".modal").show();
                        $(".modal").html(result['html']);
                        stateFoundScript()
                        console.log(result);

                        $('.modal').find("#storeStateFound").on('submit', function(e){
                            e.preventDefault();

                            var formData = this;                  
                            var dangerAlert = $('#dangerStateFound');
                            var successAlert = $('#successStateFound');
                            $.ajax({
                                url: "/store_state_found",
                                method: 'POST',
                                data: new FormData(formData),
                                processData: false,
                                dataType: 'json',
                                contentType: false,
                                success: function(result) {
                                    if(result.errors) {
                                        dangerAlert.html('');
                                        $.each(result.errors, function(key, value) {
                                          dangerAlert.show();
                                          dangerAlert.append('<strong><li>'+value+'</li></strong>');
                                        });
                                    } 
                                    else {
                                      successAlert.hide();
                                      successAlert.show();


                                        setInterval(function(){
                                            successAlert.hide();
                                            $('.modal').modal('hide');
                                            location.reload();
                                            

                                        }, 2000);
                                        
                                    }
                                    
                                }
                            });
                        });
                    }
                });        

            });

            // Create 
          $("#editStateFound").click(function(e) {
                e.preventDefault();   
                var animal_item = $(this).data('item-id');
                console.log(animal_item);
                $.ajax({
                    url: "/edit_state_found/"+animal_item,
                    method: 'GET',
                    success: function(result) {
                        $(".modal").show();
                        $(".modal").html(result['html']);
                        stateFoundScript()
                        console.log(result);

                        $('.modal').find("#updateStateFound").on('submit', function(e){
                            e.preventDefault();

                            var formData = this;                  
                            var dangerAlert = $('#dangerStateFound');
                            var successAlert = $('#successStateFound');
                            $.ajax({
                                url: "/update_state_found",
                                method: 'PATCH',
                                data: new FormData(formData),
                                processData: false,
                                dataType: 'json',
                                contentType: false,
                                success: function(result) {
                                    if(result.errors) {
                                        dangerAlert.html('');
                                        $.each(result.errors, function(key, value) {
                                          dangerAlert.show();
                                          dangerAlert.append('<strong><li>'+value+'</li></strong>');
                                        });
                                    } 
                                    else {
                                      successAlert.hide();
                                      successAlert.show();

                                        setInterval(function(){
                                            successAlert.hide();
                                            $('.modal').modal('hide');
                                            location.reload();
                                        }, 2000);                              
                                    }
                                    
                                }
                            });
                        });
                    }
                });        

            });
                     
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

            // Delete accomodation
          $('body').on('click', '#deleteStateFound', function() {
 
          var item_id = $(this).data('item-id');

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
                    url: "/delete_state_found/"+ item_id,
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


        /*euthanasia js*/
         /*  $("#euthanasia_file").fileinput({
              language: "cr",
              //required: true,
              showPreview: false,
              showUpload: false,
              showCancel: false,
              allowedFileExtensions: ["pdf"],
              elErrorContainer: '#error_euthanasia_file',
              msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
          }); */

           // Close Modal
           $(".modal").on('click', '.modal-close', function(){
                $(".modal").hide();
            });
      })
  </script>

  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush