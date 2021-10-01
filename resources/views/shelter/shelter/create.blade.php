@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')


    <div class="row">
        <div class="col-md-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <h6 class="card-title">Oporavilište - osnovne informacije</h6>
                <form action="{{ route("shelter.store") }}" method="POST" multiple>
                    @csrf
                
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Naziv pravne osobe</label>
                                <input type="text" name="name" class="form-control"  placeholder="Naziv pravne osobe">
                                @error('name')
                                    <div class="text-danger">{{$errors->first('name') }} </div>
                                @enderror
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">OIB</label>              
                                <input class="form-control oib-field" maxlength="11" name="oib" id="oib" type="text" placeholder="Unsite OIB">
                                @error('oib')
                                    <div class="text-danger">{{$errors->first('oib') }} </div>
                                @enderror
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-5">
                            <div class="form-group">
                            <label class="control-label">Adresa Sjedišta</label>
                            <input type="text" name="address" class="form-control" placeholder="Adresa Sjedišta">
                                @error('address')
                                <div class="text-danger">{{$errors->first('address') }} </div>
                                @enderror
                            </div>
                        </div><!-- Col -->                 
                  </div><!-- Row -->

                  <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label class="control-label">Mjesto i poštanski broj</label>
                            <input type="text" class="form-control" name="place_zip" placeholder="Mjesto i poštanski broj">
                                @error('place_zip')
                                    <div class="text-danger">{{$errors->first('place_zip') }} </div>
                                @enderror
                            </div>
                        </div><!-- Col -->       
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Adresa lokacije oporavilišta</label>
                            <input type="text" class="form-control" name="address_place" placeholder="Adresa lokacije oporavilišta">
                            @error('address_place')
                                <div class="text-danger">{{$errors->first('address_place') }} </div>
                            @enderror
                        </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Telefon</label>
                            <input type="text" name="telephone" class="form-control" placeholder="Telefon">
                            @error('telephone')
                                <div class="text-danger">{{$errors->first('telephone') }} </div>
                            @enderror
                        </div>
                        </div><!-- Col --> 
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label class="control-label">Fax</label>
                            <input type="text" name="fax" class="form-control" placeholder="Fax">
                                @error('fax')
                                    <div class="text-danger">{{$errors->first('fax') }} </div>
                                @enderror
                            </div>
                        </div><!-- Col -->
                  </div><!-- Row -->
                  
                    <div class="row">           
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label class="control-label">Mobitel</label>
                            <input type="text" name="mobile" class="form-control" placeholder="Mobitel">
                                @error('mobile')
                                    <div class="text-danger">{{$errors->first('mobile') }} </div>
                                @enderror
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Email adresa</label>
                            <input class="form-control mb-4 mb-md-0" name="email" data-inputmask="'alias': 'email'"/>
                            @error('email')
                                <div class="text-danger">{{$errors->first('email') }} </div>
                            @enderror
                        </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="form-group">
                            <label class="control-label">Web adresa</label>
                            <input type="text" name="web_address" class="form-control" placeholder="Web adresa">
                            @error('web_address')
                                <div class="text-danger">{{$errors->first('web_address') }} </div>
                            @enderror
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-3">
                            <div class="form-group">
                            <label class="control-label">Datum ovlaštenja oporavilišta</label>
                            <div class="input-group date datepicker" id="datePickerExample">
                                <input type="text" class="form-control" name="register_date"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                @error('register_date')
                                <div class="text-danger">{{$errors->first('register_date') }} </div>
                                @enderror
                            </div>
                            </div>
                        </div><!-- Col -->
               
                    </div><!-- Row -->
              
                    <div class="row">
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Račun pravne osobe - Naziv banke</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="Naziv Banke">
                            @error('bank_name')
                                <div class="text-danger">{{$errors->first('bank_name') }} </div>
                            @enderror
                        </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">IBAN Računa</label>
                            <input class="form-control iban-field" maxlength="21" name="iban" id="iban" type="text" placeholder="HRcc AAAA AAAB BBBB BBBB B">
                            @error('iban')
                                <div class="text-danger">{{$errors->first('iban') }} </div>
                            @enderror
                        </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">             
                            <div class="form-group">
                                <label class="control-label">Predmet obavljanje poslova</label>
                                <select class="js-example-basic-multiple w-100" name="shelter_type_id[]" multiple="multiple">
                                    @foreach ($shelterType as $code)
                                        <option value="{{ $code->id }}">{{ $code->name }}</option>
                                    @endforeach
                                </select>   
                                @error('shelter_type_id')
                                    <div class="text-danger">{{$errors->first('shelter_type_id') }} </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">            
                            <div class="form-group">
                                <label class="control-label">Šifra oporavilišta</label>
                                <input class="form-control shelter_code_field" maxlength="5" name="shelter_code" id="shelter_code" type="text" placeholder="Šifra oporavilišta">
                                @error('shelter_code')
                                    <div class="text-danger">{{$errors->first('shelter_code') }} </div>
                                @enderror
                            </div>         
                        </div>             
                    </div><!-- Row -->
                    <button type="submit" class="btn btn-primary submit">Spremi Osnovne informacije</button>
                </form>         
            </div>
          </div>
        </div>
      </div>

<div class="row mt-4" >
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Odgovorna osoba</h6>
                <p class="text-muted tx-13">Podaci o odgovornoj osobi u pravnoj osobi</p>
                <hr class="text-muted">
                    <form action="{{ route('shelter_staff.store') }}" class="forms-sample mt-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Ime i prezime</label>
                                    <input type="text" class="form-control" id="name" name="staff_legal_name" autocomplete="off" placeholder="Ime i prezime odgovorne osobe">
                                    @error('staff_legal_name')
                                        <p class="text-danger mt-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <label for="name">OIB</label>
                                    <input type="text" class="form-control" id="oib" name="staff_legal_oib" autocomplete="off" placeholder="OIB odgovorne osobe u pravnoj osobi">
                                    @error('staff_legal_oib')
                                    <p class="text-danger mt-3">{{ $message }}</p>
                                @enderror
                                </div>
                            </div>
                        </div>           
                        <div class="form-group"> 
                            <label for="name">Adresa prebivališta</label>
                            <input type="text" class="form-control" id="address" name="staff_legal_address" autocomplete="off" placeholder="adresa prebivališta">
                            @error('staff_legal_address')
                                <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group"> 
                            <label for="name">Adresa boravišta</label>
                            <input type="text" class="form-control" id="address_place" name="staff_legal_address_place" autocomplete="off" placeholder="Adresa boravišta(ako postoji)">
                            @error('staff_legal_address')
                                <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <label for="name">Kontakt telefon</label>
                                    <input type="text" class="form-control" id="phone" name="staff_legal_phone" autocomplete="off" placeholder="Kontakt telefon">
                                    @error('staff_legal_phone')
                                        <p class="text-danger mt-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <label for="name">Kontakt mobilni telefon</label>
                                    <input type="text" class="form-control" id="phone_cell" name="staff_legal_phone_cell" autocomplete="off" placeholder="Kontakt mobitel">
                                    @error('staff_legal_phone_cell')
                                    <p class="text-danger mt-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email adresa</label>
                            <input type="email" class="form-control" name="staff_legal_email" id="email" placeholder="Email">
                            @error('staff_legal_email')
                            <p class="text-danger mt-3">{{ $message }}</p>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label>Uvjerenje - kazneni postupak</label>
                            <input type="file" name="staff_legal_file_legal" class="file-upload-default">
                            <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Uvjerenje da se ne vodi kazneni postupak protiv odgovorne osobe">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Učitaj</button>
                            </span>
                            </div>
                            @error('staff_legal_file_legal')
                            <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>          
                    <button type="submit" class="btn btn-primary mr-2">Spremi odgovornu osobu</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Skrb životinja</h6>
                <p class="text-muted tx-13">Podaci o odgovornoj osobi za skrb o životinjama</p>
                <hr class="text-muted">
                    <form action="{{ route('shelter_staff.store') }}" class="forms-sample mt-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Ime i prezime</label>
                                    <input type="text" class="form-control" id="name" name="staff_care_name" autocomplete="off" placeholder="Ime i prezime odgovorne osobe">
                                    @error('staff_care_name')
                                        <p class="text-danger mt-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <label for="name">OIB</label>
                                    <input type="text" class="form-control" id="oib" name="staff_care_oib" autocomplete="off" placeholder="OIB odgovorne osobe u pravnoj osobi">
                                    @error('staff_care_oib')
                                    <p class="text-danger mt-3">{{ $message }}</p>
                                @enderror
                                </div>
                            </div>
                        </div>           
                        <div class="form-group"> 
                            <label for="name">Adresa prebivališta</label>
                            <input type="text" class="form-control" id="address" name="staff_care_address" autocomplete="off" placeholder="adresa prebivališta">
                            @error('staff_care_address')
                                <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group"> 
                            <label for="name">Adresa boravišta</label>
                            <input type="text" class="form-control" id="address_place" name="staff_care_address_place" autocomplete="off" placeholder="Adresa boravišta(ako postoji)">
                            @error('staff_care_address')
                                <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <label for="name">Kontakt telefon</label>
                                    <input type="text" class="form-control" id="phone" name="staff_care_phone" autocomplete="off" placeholder="Kontakt telefon">
                                    @error('staff_care_phone')
                                        <p class="text-danger mt-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group"> 
                                    <label for="name">Kontakt mobilni telefon</label>
                                    <input type="text" class="form-control" id="phone_cell" name="staff_care_phone_cell" autocomplete="off" placeholder="Kontakt mobitel">
                                    @error('staff_care_phone_cell')
                                    <p class="text-danger mt-3">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email adresa</label>
                            <input type="email" class="form-control" name="staff_care_email" id="email" placeholder="Email">
                            @error('staff_care_email')
                            <p class="text-danger mt-3">{{ $message }}</p>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label>Uvjerenje - kazneni postupak</label>
                            <input type="file" name="staff_care_file_contract" class="file-upload-default">
                            <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Kopija ugovora o radu ili drugog sporazuma">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Učitaj</button>
                            </span>
                            </div>
                            @error('staff_legal_file_legal')
                            <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div> 
                        <div class="form-group">
                            <label>Dokaz o odgovarajućoj osposobljenosti</label>
                            <input type="file" name="staff_care_file_contract" class="file-upload-default">
                            <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Kopija ugovora o radu ili drugog sporazuma">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Učitaj</button>
                            </span>
                            </div>
                            @error('staff_legal_file_legal')
                            <p class="text-danger mt-3">{{ $message }}</p>
                            @enderror
                        </div>          
                    <button type="submit" class="btn btn-primary mr-2">Spremi odgovornu osobu</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
  
  <script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/js/file-upload.js') }}"></script>

@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/bootstrap-maxlength.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script> 

  <script>
      // Setup maxlength
    $('.oib-field').maxlength({
        alwaysShow: true,
        validate: false,
        allowOverMax: true,
        customMaxAttribute: "90"
    });

    $('.iban-field').maxlength({
        alwaysShow: true,
        validate: false,
        allowOverMax: true,
        customMaxAttribute: "90"
    });

    $('.shelter_code_field').maxlength({
        alwaysShow: true,
        validate: false,
        allowOverMax: true,
        customMaxAttribute: "90"
    });
  </script>
@endpush