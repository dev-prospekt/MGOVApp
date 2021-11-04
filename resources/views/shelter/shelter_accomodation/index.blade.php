@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<ul class="nav shelter-nav">

  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelter.show', [ $shelter->id]) }}">Podaci o korisnicima</a>
  </li>

  <li class="nav-item">
    <a class="nav-link active" href="#">Nastambe oporavilišta</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Oprema, prehrana</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Korisnici aplikacije</a>
  </li>
</ul>


<div class="d-flex align-items-center justify-content-between">
  <h5 class="mb-3 mb-md-0">{{ $shelter->name ?? '' }}</h5>
  <div>      
      <button id="createAccomodation" href="#" type="button" class="btn btn-primary btn-icon-text" data-shelter-id="{{ $shelter->id ?? ''  }}">
        Dodaj smještajne jedinice
        <i class="btn-icon-append" data-feather="user-plus"></i>
      </button>                  
  </div>
</div>
@if($shelterAccomodationItems)
<div class="row inbox-wrapper">    
  <div class="col-lg-12"> 
    @foreach ($shelterAccomodationItems as $shelterItem)
    <div class="card mt-4">    
      <div class="card-body">
        <div class="title d-flex  justify-content-end">         
        <div>
        </div>
     
        <button  type="button" class="btn btn-primary btn-icon mr-2 edit-accomodation" data-accomodation-id="{{ $shelterItem->id ?? ''  }}" data-shelter-id="{{ $shelter->id ?? ''  }}">
          <i data-feather="check-square"></i>
        </button>       
          <a type="button" type="button" class="btn btn-danger btn-icon" >
            <i data-feather="box"></i>
      </a>
        
      </div>
      <div class="profile-page tx-13 mt-4">
        <div class="row profile-body">
          <!-- left wrapper start -->
          <div class="d-md-block col-md-12 col-xl-3 left-wrapper">
            <div class="card rounded">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                  <h6 class="card-title mb-0">{{ $shelterItem->name }}</h6>         
                </div>         
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">{{ $shelterItem->accommodationType->type_mark }}</label>
                  <p class="text-muted">{{ $shelterItem->accommodationType->type_description  }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dimenzije:</label>
                  <p class="text-muted">{{ $shelterItem->dimensions }}</p>
                </div>      
              </div>
            </div>
          </div>
          <!-- left wrapper end -->
          <!-- middle wrapper start -->
          <div class="col-md-12 col-xl-5 middle-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card rounded">
                  <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="d-flex align-items-center">
                        <h6 class="card-title mb-0">Opis</h6>                                                  
                      </div>             
                    </div>
                  </div>
                  <div class="card-body">
                    <p class="mb-3 tx-14">{{ $shelterItem->description }} </p>              
                  </div>    
                </div>
              </div>
            </div>
          </div>
          <!-- middle wrapper end -->
          <!-- right wrapper start -->
          <div class="d-xl-block col-md-12 col-xl-4 right-wrapper">
            <div class="row">
              <div class="col-md-12 grid-margin">
                <div class="card rounded">
                  <div class="card-body">
                    <h6 class="card-title">Fotografije</h6>
                    <div class="latest-photos">
                      <div class="row">
                        @foreach ($shelterItem->media as $thumbnail) 
                        <div class="col-md-4 col-sm-2">
                          <a href="{{ $thumbnail->getUrl() }}">
                          <figure>
                            <img class="img-fluid" src="{{ $thumbnail->getUrl() }}" alt="">
                          </figure>
                          </a>
                        </div>                  
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>          
            </div>
          </div>
          <!-- right wrapper end -->
        </div>
      </div>
     
        </div>
      </div>
      @endforeach
  </div>
</div>
@endif

<div class="modal"></div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script> 
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/file-upload.js') }}"></script>

<script>
 $(function() {

    //CREATE
    $("button#createAccomodation").on('click', function(e){
        e.preventDefault();
        var shelter_id = $(this).attr("data-shelter-id");
        $.ajax({
            url: "/shelters/"+shelter_id+"/accomodations/create",
            method: 'GET',
            success: function(result) {
                $(".modal").show();
                $(".modal").html(result['html']);
                $(".modal").find('#storeAccomodation #accomodationPhotosCreate').fileinput({
                    language: "cr",
                    showPreview: false,
                    showUpload: false,
                    allowedFileExtensions: ['jpg', 'png']
                });
                $('.modal').find("#storeAccomodation").on('submit', function(e){
                    e.preventDefault();
                    var formData = this;
            
                    $.ajax({
                        url: "/shelters/"+shelter_id+"/accomodations",
                        method: 'POST',
                        data: new FormData(formData),
                        processData: false,
                        dataType: 'json',
                        contentType: false,
                        success: function(result) {
                            if(result.errors) {
                                $('.alert-danger').html('');
                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                });
                            } 
                            else {
                                $('.alert-danger').hide();
                                $('.alert-success').show();
                                setInterval(function(){
                                    $('.alert-success').hide();
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

    //Edit
    $('button.edit-accomodation').on('click', function(e){
      e.preventDefault();
      var shelter_id = $(this).attr("data-shelter-id");
      var accomodation_id = $(this).attr("data-accomodation-id");
        $.ajax({
            url: "/shelters/"+shelter_id+"/accomodations/"+accomodation_id,
            method: 'GET',
            success: function(result) {
                $(".modal").show();
                $(".modal").html(result['html']);
                $(".modal").find('#updateAccomodationPhotos').fileinput({
                    language: "cr",
                    showPreview: false,
                    showUpload: false,
                    allowedFileExtensions: ["jpg", "png"],
                });
                
                $('.modal').find("#updateAccomodation").on('submit', function(e){
                    e.preventDefault();

                    var formUpdateData = new FormData(this);

                    var alertDanger = $('#dangerAccomodationUpdate');
                    var alertSuccess = $('#successAccomodationUpdate');
                    
                    $.ajax({
                        url: "/shelters/"+shelter_id+"/accomodations/"+accomodation_id,
                        type: 'POST',
                        data: formUpdateData,
                        processData: false,
                        contentType: false,
                        success: function(result) {
                      
                        if(result.errors) {
                            alertDanger.html('');
                            console.log(result);
                            $.each(result.errors, function(key, value) {
                                alertDanger.show();
                                alertDanger.append('<strong><li>'+value+'</li></strong>');
                            });
                        } else {
                        
                            alertDanger.hide();
                            alertSuccess.show();
            
                            setInterval(function(){
                                    $('.alert-success').hide();
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

      // Close Modal
      $(".modal").on('click', '.close', function(){
          $(".modal").hide();
      });
});
</script>
@endpush