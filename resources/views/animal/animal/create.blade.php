@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <div>
            <a href="/shelter/{{ auth()->user()->shelter->id }}" class="btn btn-primary">
                <i data-feather="left" data-toggle="tooltip" title="Connect"></i>
                Natrag
            </a>
        </div>
    </ol>
</nav>

<ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
        Podatci o nalazniku
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-line-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
        Životinja
        </a>
    </li>
</ul>
<div class="tab-content" id="lineTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">

                        <form action="{{ route('founder_data.store') }}" method="POST">
                            @csrf
                            @method('POST')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Služba koja je izvršila zaplijenu</label>
                                        <select id="sluzba" name="oznaka" class="form-control">
                                            <option value="">------</option>
                                            <option value="1">Državni inspektorat-inspekcija zaštite prirode</option>
                                            <option value="2">Državni inspektorat-veterinarska inspekcija</option>
                                            <option value="3">Ministarstvo unutarnjih poslova</option>
                                            <option value="4">Ministarstvo financija, Carinska uprava</option>
                                            <option value="5">fizička/pravna osoba</option>
                                            <option value="6">komunalna služba-lokalna i regionalna samouprava</option>
                                            <option value="7">nepoznato</option>
                                            <option value="8">djelatnici Javnih ustanova NP/PP ili županija</option>
                                            <option value="9">vlasnik životinje</option>
                                            <option value="10">ostalo-navesti:</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="ostalo">
                                    <div class="form-group">
                                        <label>Ostalo navesti</label>
                                        <input type="text" name="ostalo" class="form-control">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Ako se radi o službenoj osobi, podaci o službi-naziv institucije</label>
                                        <input type="file" id="founder_documents" name="documents[]" multiple />
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

                            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">

        <div class="card">
            <div class="card-body">
                <form action="{{ route('animal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                
                    <div class="row">
                        <div class="col-md-4">

                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6 class="text-muted">Životinje</h6>
                                    </div>

                                    <div class="form-group">
                                        <select name="animal_id[]" class="form-control">
                                            <option value="">------</option>
                                            @foreach ($typeArray as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
                            <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">
        
                            <div class="form-group">
                                <label>Vrsta oznake</label>
                                <select name="oznaka" class="form-control">
                                    <option value="">------</option>
                                    <option value="otvoreni prsten">otvoreni prsten</option>
                                    <option value="zatvoreni prsten">zatvoreni prsten</option>
                                    <option value="mikročip">mikročip</option>
                                    <option value="odašiljač">odašiljač</option>
                                    <option value="krilna markica">krilna markica</option>
                                    <option value="ušna markica">ušna markica</option>
                                    <option value="neoznačena">neoznačena</option>
                                    <option value="ostalo">ostalo</option>
                                </select>
                            </div>
                
                            <div class="form-group">
                                <label>Količina</label>
                                <input type="number" class="form-control" name="quantity">
                                @error('quantity')
                                    <div class="text-danger">{{$errors->first('quantity') }} </div>
                                @enderror
                            </div>
                
                            <div class="form-group">
                                <label>Datum pronalska</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="date_found" class="form-control">
                                    <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
        
                            <div class="form-group">
                                <label>Okolnosti i način pronalaska životinje</label>
                                <input type="text" class="form-control" name="okolnosti">
                            </div>
        
                            <div class="form-group">
                                <label>Lokacija na kojoj je životinja pronađena</label>
                                <input type="text" class="form-control" name="location">
                                @error('location')
                                    <div class="text-danger">{{$errors->first('location') }} </div>
                                @enderror
                            </div>
        
                            <div class="form-group">
                                <label>Dodatni opisni podaci oporavilišta o preuzimanju</label>
                                <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                            </div>
                
                            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
                        </div>
                
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dokumenti</label>

                                <input type="file" id="documents" name="documents[]" multiple />
                            </div>
        
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
                                <label>Upload stanja životinje u trenutku zaprimanja u oporavilište</label>
                                <input type="file" id="status_receiving_file" name="status_receiving_file[]" multiple />
                            </div>
                        </div>
        
                        <div class="col-md-4">
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
                                <label>Upload stanja u kojem je životinja pronađena</label>
                                <input type="file" id="status_found_file" name="status_found_file[]" multiple />
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
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>

    <script>
        $(function() {

            $("#founder_documents, #documents").fileinput({
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ["pdf"],
            });

            $("#status_receiving_file, #status_found_file").fileinput({
                language: "cr",
                maxFileCount: 2,
                showPreview: false,
                showUpload: false,
                allowedFileExtensions: ["jpg", "png",],
            });

            $('[data-toggle="tooltip"]').tooltip(); 
            
            $("#ostalo").hide();
            $("#sluzba").change(function(){
                var id = $("#sluzba").val();

                if(id != 10){
                    $("#ostalo").hide();
                }
                else {
                    $("#ostalo").show();
                }
            });
        });
    </script>
@endpush