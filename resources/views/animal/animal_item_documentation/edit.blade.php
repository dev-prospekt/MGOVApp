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

  <div class="card">
    <div class="card-body">
        <h4 class="card-title">Dokumentacija - Zaprimanje jedinke</h4>
        <form action="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.update', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id, $itemDocumentation->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
              <div class="col-md-6">
                  <div class="bordered-group">
                      <div class="form-group">
                          <label>Stanje životinje u trenutku zaprimanja u oporavilište</label>
                            <select name="state_recive" class="form-control">
                              @foreach ($animalDocType as $docType)
                                <option value="{{ $docType->id}}" {{ ( $docType->id == $itemDocumentation->state_recive) ? 'selected' : '' }}>{{ $docType->name }}</option>
                              @endforeach 
                            </select>
                         
                          @error('state_recive')
                          <div class="text-danger">{{$errors->first('state_recive') }} </div>
                           @enderror
                      </div>
          
                      <div class="form-group">
                          <label>Opis</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="state_recive_desc" rows="5">{{ $animalItem->animalDocumentation->state_recive_desc }}</textarea>
                          @error('state_recive_desc')
                          <div class="text-danger">{{$errors->first('state_recive_desc') }} </div>
                          @enderror
                      </div>
       
                        <span class="title text-secondary">Dokumentacija: </span>
                        <div class="latest-photos mt-3">         
                            @if ($itemDocumentation->getMedia('state_receive_file')->first())
                            <div class="bordered-group mt-2 mb-2">
                              <div class="latest-photos d-flex">
                                @foreach ($animalItem->animalDocumentation->getMedia('state_receive_file') as $media)
                                  @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))                    
                                    <div class="photo-item d-flex flex-column">
                                      <a href="{{ $media->getUrl() }}" data-lightbox="image-{{ $media->id }}">
                                        <figure>
                                          <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                        </figure>
                                      </a> 
                                      <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                        <i data-feather="trash"></i>
                                      </a>   
                                    </div>       
                                  @else
                                  <div class="document-item d-flex flex-column">
                                    <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>   
                                    <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                      <i data-feather="trash"></i>
                                    </a> 
                                  </div> 
                                  @endif                       
                                @endforeach                       
                              </div>
                            </div>
                            @endif                             
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
                            @foreach ($animalDocType as $docType)
                              <option value="{{ $docType->id}}" {{ ( $docType->id == $itemDocumentation->state_found) ? 'selected' : '' }}>{{ $docType->name }}</option>
                            @endforeach 
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Opis</label>
                          <textarea class="form-control" id="exampleFormControlTextarea1" name="state_found_desc" rows="5">{{ $animalItem->animalDocumentation->state_found_desc }}</textarea>
                          @error('state_found_desc')
                          <div class="text-danger">{{$errors->first('state_found_desc') }} </div>
                           @enderror
                      </div>
                      <span class="title text-secondary">Dokumentacija: </span>
                      <div class="latest-photos mt-3">         
                          @if ($itemDocumentation->getMedia('state_found_file')->first())
                          <div class="bordered-group mt-2 mb-2">
                            <div class="latest-photos d-flex">
                              @foreach ($animalItem->animalDocumentation->getMedia('state_found_file') as $media)
                                @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))                    
                                  <div class="photo-item d-flex flex-column">
                                    <a href="{{ $media->getUrl() }}" data-lightbox="image-{{ $media->id }}">
                                      <figure>
                                        <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                      </figure>
                                    </a> 
                                    <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                      <i data-feather="trash"></i>
                                    </a>   
                                  </div>       
                                @else
                                <div class="document-item d-flex flex-column">
                                  <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>   
                                  <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                    <i data-feather="trash"></i>
                                  </a> 
                                </div> 
                                @endif                       
                              @endforeach                       
                            </div>
                          </div>
                          @endif                             
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
                          @foreach ($animalDocType as $docType)
                            <option value="{{ $docType->id}}" {{ ( $docType->id == $itemDocumentation->state_reason) ? 'selected' : '' }}>{{ $docType->name }}</option>
                          @endforeach 
                        </select>
                        @error('state_reason')
                        <div class="text-danger">{{$errors->first('state_reason') }} </div>
                         @enderror
                    </div>
                    <div class="form-group">
                        <label>Opis</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" name="state_reason_desc" rows="5">{{ $animalItem->animalDocumentation->state_reason_desc }}</textarea>
                        @error('state_reason')
                        <div class="text-danger">{{$errors->first('state_reason_desc') }} </div>
                         @enderror
                    </div>
                   
                    @if ($itemDocumentation->getMedia('state_reason_file')->first())  
                      <span class="title text-secondary">Dokumentacija: </span>                  
                      <div class="bordered-group mt-2 mb-2">
                        <div class="latest-photos d-flex">
                          @foreach ($animalItem->animalDocumentation->getMedia('state_reason_file') as $media)
                            @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))                    
                              <div class="photo-item d-flex flex-column">
                                <a href="{{ $media->getUrl() }}" data-lightbox="image-{{ $media->id }}">
                                  <figure>
                                    <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                  </figure>
                                </a> 
                                <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                  <i data-feather="trash"></i>
                                </a>   
                              </div>       
                            @else
                            <div class="document-item d-flex flex-column">
                              <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>   
                              <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                <i data-feather="trash"></i>
                              </a> 
                            </div> 
                            @endif                       
                          @endforeach                       
                        </div>
                      </div>            
                    @endif 
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
                         @foreach ($markTypes as $markType)
                          <option value="{{ $markType->id}}" {{ ( $markType->id == $selectedMark) ? 'selected' : '' }}>{{ $markType->name }} ({{ $markType->desc }})</option>
                          @endforeach           
                      </select>
                  </div>

                  <div class="form-group">
                      <label>Naziv oznake</label>
                      <input type="text" name="animal_mark_note" class="form-control" value="{{ $animalItem->animalDocumentation->animalMark->animal_mark_note ?? '' }}">
                  </div>
                  <span class="title text-secondary">Dokumentacija: </span>
                  <div class="latest-photos mt-3">         
                      @if ($itemDocumentation->getMedia('animal_mark_photos')->first())
                      <div class="bordered-group mt-2 mb-2">
                        <div class="latest-photos d-flex">
                          @foreach ($animalItem->animalDocumentation->getMedia('animal_mark_photos') as $media)
                            @if (($media->mime_type == 'image/png') || ($media->mime_type == 'image/jpeg'))                    
                              <div class="photo-item d-flex flex-column">
                                <a href="{{ $media->getUrl() }}" data-lightbox="image-{{ $media->id }}">
                                  <figure>
                                    <img class="img-fluid" src="{{ $media->getUrl() }}" alt="">
                                  </figure>
                                </a> 
                                <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                  <i data-feather="trash"></i>
                                </a>   
                              </div>       
                            @else
                            <div class="document-item d-flex flex-column">
                              <a href="{{ $media->getUrl() }}">{{ $media->name }}</a>   
                              <a type="button" data-href="{{ route('item_documentation.thumbDelete', $media) }}" class="btn btn-sm btn-danger btn-icon deleteThumb">
                                <i data-feather="trash"></i>
                              </a> 
                            </div> 
                            @endif                       
                          @endforeach                       
                        </div>
                      </div>
                      @endif                             
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

                // Delete files
                $(".deleteThumb").on('click', function(e){
                e.preventDefault();
                url = $(this).attr('data-href');
                Swal.fire({
                    title: 'Jeste li sigurni?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Da, obriši!',
                    cancelButtonText: "Ne, odustani!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(result) {
                                if(result.msg == 'success'){
                                  location.reload();
                                }
                            }
                          }); 
                      }
                  });
              });
      })
  </script>

  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush