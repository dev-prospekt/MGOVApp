<div class="card">
    <div class="card-body">
        
        <form action="{{ route('shelterAnimal.seizedStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
            <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Odabir životinjske vrste</label>
                        <select name="animal_id" class="form-control" id="animalSelect">
                            <option value="">------</option>
                            @foreach ($animal as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Spol</label>
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
                        <label>Veličina</label>
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
                        <label>Dob jedinke</label>
                        <select class="form-control" name="animal_age" id="">
                        {{--  @if ($animalItem->animal_dob)
                                <option selected value="{{$animalItem->animal_dob}}">{{$animalItem->animal_dob}}</option>
                            @endif --}}
                            <option value="">Odaberi</option>
                            <option value="ADL">ADL (adultna)</option>
                            <option value="JUV">JUV (juvenilna)</option>
                            <option value="SA">SA (subadultna)</option>
                            <option value="N">N (neodređeno)</option>
                        </select>
                        @error('animal_age')
                            <div class="text-danger">{{$errors->first('animal_age') }} </div>
                        @enderror
                    </div>    
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Način držanja - solitarno/grupa</label>
                        <select class="form-control" name="solitary_or_group">
                            <option value="">------</option>
                            <option value="da">Solitarno</option>
                            <option value="ne">Grupa</option>
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
                            <div class="input-group date datepicker" id="datePickerHibernation">
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
                            <label>Mjesto zapljene</label>
                            <select class="form-control" name="place_seized_select">
                                <option value="" selected>------</option>
                                <option value="unutrašnjost RH">unutrašnjost RH</option>
                                <option value="granični prijelaz">granični prijelaz</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>mjesto/granični prijelaz</label>
                            <input type="text" class="form-control" name="place_seized">
                        </div>
    
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Datum zaplijene životinje</label>
                            <div class="input-group date datepicker" id="datePickerSeizedAnimal">
                                <input type="text" name="date_seized_animal" class="form-control">
                                <span class="input-group-addon">
                                <i data-feather="calendar"></i>
                                </span>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label>Datum zaprimanja u oporavilište</label>
                            <div class="input-group date datepicker" id="datePickerShleterStart">
                                <input type="text" name="start_date" class="form-control">
                                <span class="input-group-addon">
                                <i data-feather="calendar"></i>
                                </span>
                            </div>
                        </div>              
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Lokacija preuzimanja životinje</label>
                            <select class="form-control" name="location_retrieval_animal">
                                <option value="">Odaberi</option>
                                <option value="U oporavilištu">U oporavilištu</option>
                                <option value="Izvan oporavilišta">Izvan oporavilišta</option>
                                <option value="Preuzeli djelatnici oporavilišta">Preuzeli djelatnici oporavilišta</option>
                                <option value="Preuzela druga služba">Preuzela druga služba</option>
                            </select>
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
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="animal_found_note" rows="13"></textarea>
                            </div>              
                        </div> 
                    </div>
                </div>  
                
                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Nalaznik / služba</label>
                            <select name="founder_id" class="form-control">
                                <option selected value="{{$founder->id}}">
                                    {{$founder->name}} {{$founder->lastname}} 
                                    @if($founder->service != 'ostalo-navesti:')
                                        ({{$founder->service}})
                                    @else
                                        ({{$founder->others}})
                                    @endif
                                </option>
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
                            <label>Vrsta i broj dokumenta temeljem koga je izvršena zapljena</label>
                            <input type="text" class="form-control" name="seized_doc">
                        </div>
                        <div class="form-group">
                            <label>Upload</label>
                            <input type="file" id="vrsta_broj_dokumenta" name="seized_doc_type[]" multiple />
                            <div id="error_vrsta_broj_dokumenta"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning  mr-2">Spremite podatke</button>
                    </div>
                </div>
            </div>
        </form>
        
    </div>
</div>