@extends('layout.master')

@push('plugin-styles')
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
<div class="row inbox-wrapper">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Izmjeni smještajnu jedinicu</h6>
        <!-- Modal body -->
          <form data-action="{{ route('shelters.accomodations.update', [$shelter->id, $shelterAccomodationItem->id]) }}" id="updateAccomodation" method="POST" enctype="multipart/form-data"> 
            @method('PUT') 
            @csrf          
            <div class="form-group">
              <label>Naziv</label>
              <input type="text" class="form-control size" name="edit_accomodation_name" id="updateAccomodationName" placeholder="Naziv nastambe npr. Kavez 01" value="{{ $shelterAccomodationItem->name }}">             
            </div>
                    
            <div class="form-group">
                <label>Dimenzije</label>
                <input type="text" class="form-control size" name="edit_accomodation_size" id="updateAccomodationSize" placeholder="dimenzija u metrima D x Š x V" value="{{ $shelterAccomodationItem->dimensions }}">           
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Opis nastambe</label>
                <textarea class="form-control" id="updateAccomodationDesc" name="edit_accomodation_desc" rows="8">{{ $shelterAccomodationItem->description }}</textarea>
            </div>  
                      
            <div class="form-group">
                <label>Popratna fotodokumentacija</label>
                    <input  name="edit_accomodation_photos[]" type="file" id="updateAccomodationPhotos" multiple>
            </div>
          <button type="submit" class="submitBtn btn btn-warning">Spremi</button>      
        </form>
      </div>
    </div>
  </div>
</div>
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
    $('#updateAccomodationPhotos').fileinput({
          language: "cr",
          showPreview: false,
          showUpload: false,
          allowedFileExtensions: ['jpg', 'png']
      });

      tinymce.init({
            selector: 'textarea#updateAccomodationDesc',
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


      var formId = '#updateAccomodation';

      $(formId).on('submit', function(e) {
          e.preventDefault();

          var accomodation_desc = tinyMCE.get('updateAccomodationDesc').getContent();

         

          var formData = this;
         
          formData.append('accomodation_desc', accomodation_desc);

          
          
          //data.push({name: 'edit_accomodation_desc', value: tinyMCE.get('updateAccomodationDesc').getContent()});

           $.ajax({
              type: 'POST',
              url: $(formId).attr('data-action'),
              data: new FormData(formData),
              processData: false,
              dataType: 'json',
              contentType: false,
              success: function (response, textStatus, xhr) {
                location.reload();
              },
              complete: function (xhr) {
                  
              },
              error: function (XMLHttpRequest, textStatus, errorThrown) {
                  var response = XMLHttpRequest;

              }
          });  
      });

  });
</script>
@endpush