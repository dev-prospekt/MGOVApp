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
  <h5 class="mb-3 mb-md-0">Smještajna jedinica</h5>
  <div>      
      <button id="createAccomodation" href="#" type="button" class="btn btn-primary btn-icon-text" data-shelter-id="{{ $shelter->id ?? ''  }}">
        Dodaj smještajne jedinice
        <i class="btn-icon-append" data-feather="user-plus"></i>
      </button>                  
  </div>
</div>
@if($shelterAccomodationItem)
<div class="row inbox-wrapper mt-3">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3 email-aside border-lg-right">
            <div class="aside-content">
              <div class="aside-header">
               <span class="title">{{ $shelterAccomodationItem->accommodationType->name }}</span>
               <p class="description mt-3"><span class="text-secondary">Numeracija: </span> {{ $shelterAccomodationItem->accommodationType->type_mark  }}</p>
                <p class="description mt-3"><span class="text-secondary">Opis oznake: </span> {{ $shelterAccomodationItem->accommodationType->type_description  }}</p>
              </div>
              
              <div class="aside-nav collapse">
            
                <span class="title">Akcije</span>
                <ul class="nav nav-pills nav-stacked">
                  <li>
                    <a href="{{ route('shelters.accomodations.edit', [$shelter->id, $shelterAccomodationItem->id]) }}"><i data-feather="tag" class="text-warning"></i> Izmjeni jedinicu</a>
                  </li>
                  <li><a href="#">
                    <i data-feather="tag" class="text-primary"></i> Povratak na popis</a>
                  </li>
                  <li>
                    <a href="#"> <i data-feather="tag" class="text-danger"></i> Brisanje jedinice</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-9 email-content">
            <div class="email-head">
              <div class="email-head-subject">
                <div class="title d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <span class="text-secondary">Naziv jedinice: </span>
                    <span class="ml-2"> {{ $shelterAccomodationItem->name }}</span>
                  </div>         
                </div>
              </div>
              <div class="email-head-sender d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center">          
                  <span class="title text-secondary">Dimenzije: </span>
                  <div class="sender d-flex align-items-center">
                    <span>{{ $shelterAccomodationItem->dimensions }}</span>
                
                  </div>
                </div>        
              </div>
            </div>
            <div class="email-body">
              <div class="title mb-3"><span class="title text-secondary">Opis jedinice: </span></div>
              {!! $shelterAccomodationItem->description !!}
            
            </div>
            <div class="email-attachments">
              <span class="title text-secondary">Fotodokumentacija: </span>
              <div class="latest-photos mt-3">
                <div class="row">
                  @foreach ($shelterAccomodationItem->media as $thumbnail) 
                  <div class="col-md-3 col-sm-2">
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
  </div>
</div>
@endif

<div class="modal"></div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script> 
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/file-upload.js') }}"></script>
<script src="{{ asset('assets/js/tinymce.js') }}"></script>
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
                    // file input plugin
                    $(".modal").find('#storeAccomodation #accomodationPhotosCreate').fileinput({
                        language: "cr",
                        showPreview: false,
                        showUpload: false,
                        allowedFileExtensions: ['jpg', 'png']
                    });
                    // tinyMCE editor
                    tinymce.init({
                    selector: 'textarea#accomodationDesc',
                    height: 400,
                    menubar: false,
                    plugins: [
                      'advlist autolink lists link charmap print preview anchor',
                      'searchreplace visualblocks',
                      'table paste help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat',
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px; color:#fff; }'
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

                        var formUpdateData = this; 

                        var alertDanger = $('#dangerAccomodationUpdate');
                        var alertSuccess = $('#successAccomodationUpdate');
                        
                        $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                          }
                      });
      
                        $.ajax({
                            url: "/shelters/"+shelter_id+"/accomodations/"+accomodation_id,
                            type:'POST',
                            data: new FormData(formUpdateData),
                            processData: false,
                            dataType: 'json',
                            contentType: false,
                            success: function(result) {
                          
                            if(result.errors) {
                                alertDanger.html('');
                                
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


          // Delete accomodation
          $('body').on('click', '.delete-accomodation', function() {

           var accomodation_id = $(this).data('accomodation-id');
           var shelter_id = $(this).data('shelter-id');

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
                    url: "/shelters/" + shelter_id + "/accomodations/"+ accomodation_id,
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

 // Close Modal
 $(".modal").on('click', '.modal-close', function(){
            $(".modal").hide();
        });


});
</script>
@endpush