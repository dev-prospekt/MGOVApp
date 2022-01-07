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
       <a href="/shelters/{{ $animalItem->shelter_id }}/animal_groups/{{ $animalItem->animal_group_id }}/animal_items/{{ $animalItem->id }}" type="button" class="btn btn-primary btn-sm btn-icon-text">
          Povratak na popis
          <i class="btn-icon-append" data-feather="clipboard"></i>
        </a> 
        
        <a href="/shelters/{{ $animalItem->shelter_id }}/animal_groups/{{ $animalItem->animal_group_id }}" type="button" class="btn btn-warning btn-sm btn-icon-text">
          Premještaj jedinke
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

  <div class="card">
    <div class="card-body">
        <h4 class="card-title">Dokumentacija - Zaprimanje jedinke</h4>
        <form action="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.store', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
            <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">

            <div class="row">
              <div class="col-md-6">
                  <div class="bordered-group">
                      <div class="form-group">
                          <label>Stanje životinje u trenutku zaprimanja u oporavilište</label>
                          <select name="state_recive" class="form-control">
                              <option value="">----</option>
                              @foreach ($stateTypes as $type)
                              <option value="{{ $type->id }}">{{ $type->name }}</option>
                              @endforeach
                          </select>
                          @error('state_recive')
                          <div class="text-danger">{{$errors->first('state_recive') }} </div>
                           @enderror
                      </div>
          
                      <div class="form-group">
                          <label>Opis</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="state_recive_desc" rows="5"></textarea>
                          @error('state_recive_desc')
                          <div class="text-danger">{{$errors->first('state_recive_desc') }} </div>
                           @enderror
                      </div>
                      <div class="form-group">
                        <label>Učitaj dokument <span class="text-muted">(pdf,jpg,png,doc,docx)</span></label>
                          <input type="file" id="stateRecivedFile" name="state_receive_file[]" multiple />
                          <div id="error_state_recive_file"></div>
                      </div>
                  </div>
              </div>
                <div class="col-md-6">
                  <div class="bordered-group">
                      <div class="form-group">
                          <label>Stanje u kojem je životinja pronađena</label>
                          <select name="state_found" class="form-control">
                              <option value="">----</option>
                              @foreach ($stateTypes as $type)
                              <option value="{{ $type->id }}">{{ $type->name }}</option>
                              @endforeach
                          </select>
                          @error('state_found')
                          <div class="text-danger">{{$errors->first('state_recive') }} </div>
                           @enderror
                      </div>
                      <div class="form-group">
                          <label>Opis</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="state_found_desc" rows="5"></textarea>
                          @error('state_found_desc')
                          <div class="text-danger">{{$errors->first('state_found_desc') }} </div>
                           @enderror
                      </div>
                      <div class="form-group">
                        <label>Učitaj dokument <span class="text-muted">(pdf,jpg,png,doc,docx)</span></label>
                          <input type="file" id="stateFoundFile" name="state_found_file[]" multiple />
                          <div id="error_state_found_file"></div>
                      </div>
                  </div>
                </div>
          </div> 
          <div class="separator"></div>
          <div class="row">
            <div class="col-md-6">
                <div class="bordered-group">
                    <div class="form-group">
                        <label>Razlog zaprimanja životinje u oporavilište</label>
                        <select name="state_reason" class="form-control">
                            <option value="">----</option>
                              @foreach ($stateTypes as $type)
                              <option value="{{ $type->id }}">{{ $type->name }}</option>
                              @endforeach
                        </select>
                        @error('state_reason')
                        <div class="text-danger">{{$errors->first('state_reason') }} </div>
                         @enderror
                    </div>
                    <div class="form-group">
                        <label>Opis</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="state_reason_desc" rows="5"></textarea>
                        @error('state_reason')
                        <div class="text-danger">{{$errors->first('state_reason_desc') }} </div>
                         @enderror
                    </div>
                    <div class="form-group">
                      <label>Učitaj dokument <span class="text-muted">(pdf,jpg,png,doc,docx)</span></label>
                        <input type="file" id="stateReasonFile" name="state_reason_file[]" multiple />
                        <div id="error_reason_file"></div>
                    </div>
                </div>
            </div>    
            
            <div class="col-md-6">
              <div class="bordered-group">        
                  <div class="form-group">
                      <label>Vrsta oznake</label>
                      <select name="animal_mark" class="form-control">
                          <option selected disabled>------</option>
                           @foreach ($markTypes as $markType)
                          <option value="{{ $markType->id }}">{{ $markType->name }} ({{ $markType->desc }})</option>
                          @endforeach            
                      </select>
                  </div>

                  <div class="form-group">
                      <label>Naziv oznake</label>
                      <input type="text" name="animal_mark_note" class="form-control">
                  </div>
                  <div class="form-group">
                      <label>Učitaj dokument <span class="text-muted">(jpg,png)</span></label>
                      <input type="file" id="animalMarkPhotos" name="animal_mark_photos[]" multiple />
                      <div id="error_animal_mark_photos"></div>
                  </div>      
              </div>
          </div> 
        </div>
          <div class="row mt-3">
            <div class="col-md-12">
                <div class="d-flex justify-content-end">
                    <input type="submit" class="btn btn-warning  mr-2" value="Spremi dokumentaciju">
                </div>
               
            </div>
        </div>
        </form>
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
                     
            
              $("#stateFoundFile").fileinput({
                  language: "cr",
                  //required: true,
                  showPreview: false,
                  showUpload: false,
                  showCancel: false,
                  maxFileSize: 1500,
                  msgSizeTooLarge: '"{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                  allowedFileExtensions: ["pdf", "jpg", "png", 'doc', 'docx'],
                  elErrorContainer: '#error_state_found_file',
                  msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
               });
            

           
              $("#stateRecivedFile").fileinput({
                  language: "cr",
                  //required: true,
                  showPreview: false,
                  showUpload: false,
                  showCancel: false,
                  maxFileSize: 1500,
                  msgSizeTooLarge: '"{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                  allowedFileExtensions: ["pdf", "jpg", "png", 'doc', 'docx'],
                  elErrorContainer: '#error_state_recive_file',
                  msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
               });
            
               $("#stateReasonFile").fileinput({
                  language: "cr",
                  //required: true,
                  showPreview: false,
                  showUpload: false,
                  showCancel: false,
                  maxFileSize: 1500,
                  msgSizeTooLarge: '"{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                  allowedFileExtensions: ["pdf", "jpg", "png", 'doc', 'docx'],
                  elErrorContainer: '#error_reason_file',
                  msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
               });

               $("#animalMarkPhotos").fileinput({
                  language: "cr",
                  //required: true,
                  showPreview: false,
                  showUpload: false,
                  showCancel: false,
                  maxFileSize: 1500,
                  msgSizeTooLarge: '"{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                  allowedFileExtensions: ["pdf", "jpg", "png", 'doc', 'docx'],
                  elErrorContainer: '#error_mark_photos',
                  msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
               });

            // Delete state Found
          $('body').on('click', '#deleteStateFound', function() {
 
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

          // Delete state Found
          $('body').on('click', '#deleteStateRecived', function() {

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