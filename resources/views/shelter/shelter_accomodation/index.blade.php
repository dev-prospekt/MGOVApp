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
      <a id="createAccomodation" href="{{ route('shelters.accomodations.create', $shelter->id) }}" type="button" class="btn btn-primary btn-icon-text">
        Dodaj smještajne jedinice
        <i class="btn-icon-append" data-feather="user-plus"></i>
      </a>                  
  </div>
</div>
<div class="row mt-4">

  <div class="col-lg-12 col-xl-12 stretch-card">
    <div class="card ">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Popis smještajnih jedinica</h6>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                
                <th>Oznaka</th>
                <th>Opis oznake</th> 
                <th>Tip jedinice</th>
                <th class="pt-0">Naziv jedinice</th>                    
                <th>Dimenzije</th>
                <th class="pt-0">Akcija</th> 
              </tr>
            </thead>
            <tbody>
              @foreach ($shelterAccomodationItems as $shelterItem)
              <tr>
               
                <td>{{ $shelterItem->accommodationType->type_mark }}</td>
                <td style="width:25%;" class="td-nowrapp">{{ $shelterItem->accommodationType->type_description  }}</td> 
                <td>{{ $shelterItem->accommodationType->name }}</td>
                <td>{{ $shelterItem->name }}</td>
                 
                <td>{{ $shelterItem->dimensions }}</td>
                <td>
                  <div class="d-flex align-items-center">
                    <a href="{{ route('shelters.accomodations.show', [$shelter->id, $shelterItem->id]) }}" class="btn btn-xs btn-info mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Pregled
                    </a>
                
                    <a href="{{ route('shelters.accomodations.edit', [$shelter->id, $shelterItem->id]) }}" class="btn btn-xs btn-primary mr-2">
                        <i class="mdi mdi-tooltip-edit"></i> 
                        Uredi
                    </a>
                </div>  
                </td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </div> 
    </div>
  </div>
</div> <!-- row -->


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