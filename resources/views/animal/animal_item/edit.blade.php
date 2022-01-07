@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between mb-3">
    <div> <h5 class="mb-3 mb-md-0">Izmjena podataka</h5></div>
    <div>      
       <a href="/shelters/{{ $animalItem->shelter_id }}/animal_groups/{{ $animalItem->animal_group_id }}/animal_items/{{ $animalItem->id }}" type="button" class="btn btn-primary btn-sm btn-icon-text">
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
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Dokumentacija jedinke</a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.animal_groups.animal_items.animal_item_care_end.index', [$animalItem->shelter_id, $animalItem->animal_group_id, $animalItem->id]) }}">Završetak skrbi</a>
    </li>
  </ul>

    <div class="row">
        <div class="col-md-12">
            <div class="mb-2">
                @if($msg = Session::get('msg_update'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif
    
                @if($msg = Session::get('error'))
                <div id="dangerMessage" class="alert alert-danger"> {{ $msg }}</div>
                @endif
            </div>
        </div>
    </div> 
     
    <div class="row">  
        <div class="col-md-6">               
            <div class="card">
                <div class="card-body">
                    <form action="{{ route("animal_item.update", $animalItem->id) }}" method="POST">
                        @csrf
                        @method('PATCH')                
                            @if ($size)
                            <div class="form-group">
                                <label>Veličina</label>
                                <select class="form-control" name="animal_size_attributes_id" id="">
                                    <option value="">Odaberi</option>
                                    @foreach ($size->sizeAttributes as $siz)
                                        @if ($animalItem->animal_size_attributes_id == $siz->id)
                                            <option selected value="{{$siz->id}}">{{ $siz->name }}</option>
                                        @else
                                            <option value="{{ $siz->id }}">{{ $siz->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('animal_size_attributes_id')
                                    <div class="text-danger">{{$errors->first('animal_size_attributes_id') }} </div>
                                @enderror
                            </div>
                            @endif
                            <div class="form-group">
                                <label>Dob jedinke</label>
                                <select class="form-control" name="animal_dob" id="">
                                    @if ($animalItem->animal_age)
                                        <option selected value="{{$animalItem->animal_age}}">{{$animalItem->animal_age}}</option>
                                    @endif
                                    <option value="">Odaberi</option>
                                    <option value="ADL(adultna)">ADL (adultna)</option>
                                    <option value="JUV(juvenilna)">JUV (juvenilna)</option>
                                    <option value="SA(subadultna)">SA (subadultna)</option>
                                    <option value="N(neodređeno)">N (neodređeno)</option>
                                </select>
                                @error('animal_dob')
                                    <div class="text-danger">{{$errors->first('animal_dob') }} </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Spol</label>
                                <select class="form-control" name="animal_gender" id="">
                                    @if ($animalItem->animal_gender)
                                        <option selected value="{{$animalItem->animal_gender}}">{{$animalItem->animal_gender}}</option>
                                    @endif
                                    <option value="">Odaberi</option>
                                    <option value="M(mužjak)">M (mužjak)</option>
                                    <option value="Ž/F(ženka)">Ž/F (ženka)</option>
                                    <option value="N(nije moguće odrediti)">N (nije moguće odrediti)</option>
                                </select>
                                @error('animal_gender')
                                    <div class="text-danger">{{$errors->first('animal_gender') }} </div>
                                @enderror
                            </div>  
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning  mr-2">Ažuriraj podatke</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                       
        </div>             
             
        <div class="col-md-6">    
            <div class="card">
                <div class="card-body">
                    <form action="/animalItem/update/{{$animalItem->id}}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="form-group" id="hib_est_from_to">
                                <label>Hibernacija/estivacija</label>
                                <div class="d-flex">
                                    <div class="input-group date datepicker" id="datePickerExample">
                                        <input type="text" name="hib_est_from" class="form-control hib_est_from" value="{{ $animalItem->dateRange->hibern_start }}">
                                        <span class="input-group-addon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                    <div class="input-group date datepicker" id="datePickerExample">
                                        <input type="text" name="hib_est_to" class="form-control hib_est_to" value="{{ $animalItem->dateRange->hibern_end }}">
                                        <span class="input-group-addon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="period">
                                @if ($totalDays != 0)
                                <label>Razdoblje provođenja proširene skrbi <strong class="text-warning">(ostalo {{ $totalDays }} dana)</strong></label>
                                <div class="d-flex">
                                    <div class="input-group date datepicker" id="datePickerExample">
                                        <input type="text" name="full_care_start" class="form-control full_care_start">
                                        <span class="input-group-addon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                    <div class="input-group date datepicker" id="datePickerExample">
                                        <input type="text" name="full_care_end" class="form-control full_care_end">
                                        <span class="input-group-addon">
                                            <i data-feather="calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Promjena Solitarna ili Grupa</label>
                                        <select class="form-control" name="solitary_or_group_type" id="">
                                            <option value="">---</option>
                                            <option value="Grupa">Grupa</option>
                                            <option value="Solitarno">Solitarno</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Odabir datuma za promjenu stanja</label>
                                        <div class="input-group date datepicker" id="datePickerExample">
                                            <input type="text" name="solitary_or_group_end" class="form-control end_date" >
                                            <span class="input-group-addon">
                                                <i data-feather="calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>                      
                            </div> 
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-warning  mr-2">Ažuriraj podatke</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                   
        </div>                                     
    </div>
    
          
                
@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(function() {
            $("#euthanasia_file").fileinput({
                language: "cr",
                required: true,
                showPreview: false,
                showUpload: false,
                showCancel: false,
                maxFileSize: 1500,
                msgSizeTooLarge: '"{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                allowedFileExtensions: ["pdf"],
                elErrorContainer: '#error_euthanasia_file',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });

            $("#file").fileinput({
                language: "cr",
                required: true,
                showPreview: false,
                showUpload: false,
                maxFileSize: 1500,
                msgSizeTooLarge: '"{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                allowedFileExtensions: ["pdf"],
                elErrorContainer: '#error_file',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });

            // Delete files
            $(".deleteFile").on('click', function(e){
                e.preventDefault();

                url = $(this).attr('data-href');

                Swal.fire({
                    title: 'Jeste li sigurni?',
                    text: "Želite obrisati oporavilište i više neće biti dostupno!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Da, obriši!'
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
@endpush