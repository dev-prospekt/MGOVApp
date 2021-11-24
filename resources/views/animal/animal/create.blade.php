@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between">
    <h5 class="mb-3 mb-md-0">Dodavanje jedinku/e u oporavilište</h5>
    <div>
        <a type="button" class="btn btn-warning btn-icon-text" href="/shelter/{{ auth()->user()->shelter->id }}">
           
            Povratak na popis
            <i class="btn-icon-append" data-feather="clipboard"></i>
        </a>
    </div>
  </div>

<ul class="nav nav-tabs nav-tabs-line mt-2" id="lineTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
        1. Podaci o nalazniku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-line-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
        2. Podaci o zaprimanju jedinke/grupe
        </a>
    </li>
</ul>

<div class="tab-content " id="lineTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                            @if($msg = Session::get('founder'))
                            <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                            @endif

                        <form action="{{ route('founder_data.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Služba koja je izvršila zaplijenu</label>
                                        <select id="sluzba" name="service" class="form-control">
                                            <option value="">------</option>
                                            <option value="Državni inspektorat-inspekcija zaštite prirode">Državni inspektorat-inspekcija zaštite prirode</option>
                                            <option value="Državni inspektorat-veterinarska inspekcija">Državni inspektorat-veterinarska inspekcija</option>
                                            <option value="Ministarstvo unutarnjih poslova">Ministarstvo unutarnjih poslova</option>
                                            <option value="Ministarstvo financija, Carinska uprava">Ministarstvo financija, Carinska uprava</option>
                                            <option value="fizička/pravna osoba">fizička/pravna osoba</option>
                                            <option value="komunalna služba-lokalna i regionalna samouprava">komunalna služba-lokalna i regionalna samouprava</option>
                                            <option value="nepoznato">nepoznato</option>
                                            <option value="djelatnici Javnih ustanova NP/PP ili županija">djelatnici Javnih ustanova NP/PP ili županija</option>
                                            <option value="vlasnik životinje">vlasnik životinje</option>
                                            <option value="ostalo-navesti:">ostalo-navesti:</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" id="ostalo">
                                    <div class="form-group">
                                        <label>Ostalo navesti</label>
                                        <input type="text" name="others" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ime</label>
                                        <input type="text" name="name" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Prezime</label>
                                        <input type="text" name="lastname" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Adresa</label>
                                        <input type="text" name="address" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Država (prebivališta)</label>
                                        <input type="text" name="country" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kontakt mobitel/telefon</label>
                                        <input type="text" name="contact" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email adresa</label>
                                        <input type="text" name="email" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Ako se radi o službenoj osobi, podaci o službi-naziv institucije</label>
                                        <input type="file" id="founder_documents" name="founder_documents[]" multiple />
                                        <div id="error_founder_documents"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Dodaj nalaznika</button>
                            
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">
        <div class="row align-items-start mt-4 mb-4">
            <div class="col-md-12">
                <p class="text-muted tx-13 mb-3 mb-md-0"> <span class="text-danger">NAPOMENA:</span> Svi podaci se kopiraju za svaku jedinku unutar grupe (ovisno o količini), naknadno možete promijeniti podatke vezano za svaku jedinku zasebno</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body">
                
                <form action="{{ route('animal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
                    <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">
        
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>1. Odabir životinjske vrste</label>
                                <select name="animal_id[]" class="form-control" id="animalSelect">
                                    <option value="">------</option>
                                    @foreach ($typeArray as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>2. Količina (broj jedinki)</label>
                                <input type="number" class="form-control" name="quantity">
                                @error('quantity')
                                    <div class="text-danger">{{$errors->first('quantity') }} </div>
                                @enderror
                            </div>
                        </div>

                       <div class="col-md-3">
                        <div class="form-group">
                            <label>3. Spol</label>
                            <select class="form-control" name="animal_gender" id="">
                                {{-- @if ($animalItem->animal_dob)
                                    <option selected value="{{$animalItem->animal_gender}}">{{$animalItem->animal_gender}}</option>
                                @endif --}}
                                <option value="">Odaberi</option>
                                <option value="muzjak">M (mužjak)</option>
                                <option value="zenka">Ž/F (ženka)</option>
                                <option value="nije moguce odrediti">N (nije moguće odrediti)</option>
                            </select>
                            @error('animal_gender')
                                <div class="text-danger">{{$errors->first('animal_gender') }} </div>
                            @enderror
                        </div>
                       </div>

                       <div class="col-md-3">
                        <div class="form-group">
                            <label>6. Veličina</label>
                            <select class="form-control" name="animal_size_attributes_id" id="animalSize">
                            </select>
                            @error('animal_size_attributes_id')
                                <div class="text-danger">{{$errors->first('animal_size_attributes_id') }} </div>
                            @enderror
                        </div>
                       </div>
                    </div>

                      <div class="row">
                        <div class="col-md-4">

                            <div class="form-group">
                                <label>9. Lokacija pronalaska</label>
                                <input type="text" class="form-control" name="location">
                                @error('location')
                                    <div class="text-danger">{{$errors->first('location') }} </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>7. Datum pronalska</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="date_found" class="form-control">
                                    <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
                      
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>8. Datum zaprimanja u oporavilište</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="start_date" class="form-control">
                                    <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>4. Dob jedinke</label>
                                    <select class="form-control" name="animal_dob" id="">
                                       {{--  @if ($animalItem->animal_dob)
                                            <option selected value="{{$animalItem->animal_dob}}">{{$animalItem->animal_dob}}</option>
                                        @endif --}}
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
                            </div>  
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Način držanja - solitarno/grupa</label>
                                    <select class="form-control" name="animal_keep_type">
                                        <option value="">------</option>
                                        <option value="Solitarno">Solitarno</option>
                                        <option value="Grupa">Grupa</option>
                                    </select>
                                </div> 
                    
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Način držanja: Hibernacija/estivacija</label>
                                    <select class="form-control hib_est" name="hib_est">
                                        <option value="">------</option>
                                        <option value="da">Da</option>
                                        <option value="ne">Ne</option>
                                    </select>
                                </div>
                           
                                <div class="form-group" id="hib_est_from_to">
                                    <label>Hibernacija/estivacija</label>
                                    <div class="input-group" id="daterangepicker">
                                        <div class="input-group date datepicker" id="datePickerExample">
                                            <input type="text" name="hibern_start" class="form-control">
                                            <span class="input-group-addon">
                                            <i data-feather="calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <div class="row">
                          <div class="separator"></div>
                      </div>

                      <div class="row">
                        <div class="col-md-4">
                            <div class="bordered-group">
                                <div class="form-group">
                                    <label>Okolnosti i način pronalaska životinje</label>
                                    <div class="form-group">
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="5" name="animal_found_note"></textarea>
                                    </div>              
                                </div> 
                            </div>                 
                        </div>
           
                        <div class="col-md-4">
                            <div class="bordered-group">
                                <div class="form-group">
                                    <label>10. Nalaznik</label>
                                    <select name="founder_id" class="form-control">
                                        <option value="">------</option>
                                        @foreach ($founder as $fo)
                                            <option value="{{$fo->id}}">
                                                {{$fo->name}} {{$fo->lastname}} 
                                                @if($fo->service != 'ostalo-navesti:')
                                                    ({{$fo->service}})
                                                @else
                                                    ({{$fo->others}})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            <div class="form-group">
                                <label>Dodatna napomena</label>
                                <input type="text" name="founder_note" class="form-control">
                            </div>
                            </div>
                        </div>  
                        <div class="col-md-4">
                            <div class="bordered-group">
                                <div class="form-group">
                                    <label>5. Vrsta oznake</label>
                                    <select name="animal_mark" class="form-control">
                                        <option selected disabled>------</option>
                                        @foreach ($markTypes as $markType)
                                        <option value="{{ $markType->id }}">{{ $markType->name }} ({{ $markType->desc }})</option>
                                        @endforeach              
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Naziv oznake</label>
                                    <input type="text" name="animal_mark_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Upload <strong>(JPG, PNG)</strong></label>
                                    <input type="file" id="animal_mark_photos" name="animal_mark_photos[]" multiple />
                                    <div id="error_animal_mark_photos"></div>
                                </div>
                            </div>
                        </div>                                
                    </div>

                    <div class="row">
                        <div class="separator"></div>
                    </div>
                      
                      <div class="row">
                        <div class="col-md-4">
                            <div class="bordered-group">
                                <div class="form-group">
                                    <label>Stanje životinje u trenutku zaprimanja u oporavilište</label>
                                    <select name="status_receiving" class="form-control">
                                        <option value="">----</option>
                                        <option value="iscrpljena/dehidrirana-bez vanjskih ozljeda">iscrpljena/dehidrirana-bez vanjskih ozljeda</option>
                                        <option value="ozlijeđena/ranjena">ozlijeđena/ranjena</option>
                                        <option value="otrovana">otrovana</option>
                                        <option value="bolesna">bolesna</option>
                                        <option value="uginula">uginula</option>
                                        <option value="ostalo">ostalo</option>
                                    </select>
                                </div>
                       
                                <div class="form-group">
                                    <label>Opis</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="receiving_note" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload <strong>(JPG, PNG)</strong></label>
                                    <input type="file" id="status_receiving_file" name="status_receiving_file[]" multiple />
                                    <div id="error_status_receiving_file"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bordered-group">
                                <div class="form-group">
                                    <label>Stanje u kojem je životinja pronađena</label>
                                    <select name="status_found" class="form-control">
                                        <option value="">----</option>
                                        <option value="iscrpljena/dehidrirana-bez vanjskih ozljeda">iscrpljena/dehidrirana-bez vanjskih ozljeda</option>
                                        <option value="ozlijeđena/ranjena">ozlijeđena/ranjena</option>
                                        <option value="otrovana">otrovana</option>
                                        <option value="bolesna">bolesna</option>
                                        <option value="uginula">uginula</option>
                                        <option value="ostalo">ostalo</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Opis</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name ="found_note" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload <strong>(JPG, PNG)</strong></label>
                                    <input type="file" id="status_found_file" name="status_found_file[]" multiple />
                                    <div id="error_status_found_file"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bordered-group">
                                <div class="form-group">
                                    <label>Razlog zaprimanja životinje u oporavilište</label>
                                    <select name="status_reason" class="form-control">
                                        <option value="">----</option>
                                        <option value="iscrpljena/dehidrirana-bez vanjskih ozljeda">iscrpljena/dehidrirana-bez vanjskih ozljeda</option>
                                        <option value="ozlijeđena/ranjena">ozlijeđena/ranjena</option>
                                        <option value="otrovana">otrovana</option>
                                        <option value="bolesna">bolesna</option>
                                        <option value="uginula">uginula</option>
                                        <option value="ostalo">ostalo</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Opis</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="reason_note" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload <strong>(PDF)</strong></label>
                                    <input type="file" id="reason_file" name="reason_file[]" multiple />
                                    <div id="error_reason_file"></div>
                                </div>
                            </div>
                        </div>    
                    </div>                                
                    <div class="row mt-3">
                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning btn-md mr-2">Spremite podatke</button>
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
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
@endpush

@push('custom-scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(function() {
            if($('div#datePickerExample').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('div#datePickerExample').datepicker({
                    format: "mm/dd/yyyy",
                    todayHighlight: true,
                    autoclose: true,
                });
                $('div#datePickerExample').datepicker('setDate', today);
            }

            $("#founder_documents").fileinput({
                required: true,
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ['pdf', 'doc', 'docx', 'jpg', 'png'],
                elErrorContainer: '#error_founder_documents',
                msgInvalidFileExtension: 'Nevažeći format "{name}". Podržani su: "{extensions}"',
            });
            $("#documents").fileinput({
                required: true,
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ["pdf"],
                elErrorContainer: '#error_documents',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });
            $("#reason_file").fileinput({
                required: true, 
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ['pdf', 'doc', 'docx', 'jpg', 'png'],
                elErrorContainer: '#error_reason_file',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });
            $("#status_found_file").fileinput({
                required: true,
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ["jpg", "png",],
                elErrorContainer: '#error_status_found_file',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });
            $("#status_receiving_file").fileinput({
                required: true,
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ["jpg", "png",],
                elErrorContainer: '#error_status_receiving_file',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });

            $("#animal_mark_photos").fileinput({
                required: true,
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ["jpg", "png",],
                elErrorContainer: '#error_animal_mark_photos',
                msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
            });

            $('[data-toggle="tooltip"]').tooltip(); 

            // SLUZBA
            $("#ostalo").hide();
            $("#sluzba").change(function(){
                var id = $("#sluzba").val();

                if(id != 'ostalo-navesti:'){
                    $("#ostalo").hide();
                }
                else {
                    $("#ostalo").show();
                }
            });

            //getAnimal size based on animal
            $("#animalSelect").change(function(){
            $.ajax({
                url: "{{ route('animals.get_by_size') }}?animal_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#animalSize').html(data.html);
                }
            });
        });

            // HIBERNACIJA
            $("#hib_est_from_to").hide();
            $(".hib_est").change(function(){
                var id = $(".hib_est").val();

                if(id != 'da'){
                    $("#hib_est_from_to").hide();
                }
                else {
                    $("#hib_est_from_to").show();
                }
            });
        });
    </script>
@endpush