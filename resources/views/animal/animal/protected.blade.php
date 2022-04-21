<div class="card">
    <div class="card-body">
        
        <form action="{{ route('shelterAnimal.protectedStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
            <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Odabir životinjske vrste</label>
                        <select name="animal_id" class="js-example-basic-single w-100" id="animalSelect" required>
                            <option value="">------</option>
                            @foreach ($animal as $item)
                                <option value="{{ $item->id }}">{{ $item->latin_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Spol</label>
                    <select class="form-control" name="animal_gender" id="" required>
                        {{-- @if ($animalItem->animal_dob)
                            <option selected value="{{$animalItem->animal_gender}}">{{$animalItem->animal_gender}}</option>
                        @endif --}}
                        <option value="">Odaberi</option>
                        @foreach ($animalDob as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Veličina</label>
                    <select class="form-control" name="animal_size_attributes_id" id="animalSize" required>
                    </select>
                </div>
            </div>
            </div>

            <div class="row">
                <div class="col-md-3">

                    <div class="form-group">
                        <label>Lokacija pronalaska</label>
                        <input type="text" class="form-control" name="location" required>
                    </div>
                </div>

             

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Lokacija preuzimanja životinje</label>
                        <select class="form-control" name="location_animal_takeover" id="" required>
                            <option value="">Odaberi</option>
                            @foreach ($animalLocationTakeover as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> 
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Datum pronalska</label>
                        <div class="input-group date datepicker" id="datePickerExample">
                            <input type="text" name="date_found" class="form-control" required>
                            <span class="input-group-addon">
                            <i data-feather="calendar"></i>
                            </span>
                        </div>
                    </div>
            
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Datum zaprimanja u oporavilište</label>
                        <div class="input-group date datepicker" id="datePickerExample">
                            <input type="text" name="start_date" class="form-control" required>
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
                        <label>Dob jedinke</label>
                        <select class="form-control" name="animal_age" id="" required>
                        {{--  @if ($animalItem->animal_dob)
                                <option selected value="{{$animalItem->animal_dob}}">{{$animalItem->animal_dob}}</option>
                            @endif --}}
                            <option value="">Odaberi</option>
                            <option value="ADL(adultna)">ADL (adultna)</option>
                            <option value="JUV(juvenilna)">JUV (juvenilna)</option>
                            <option value="SA(subadultna)">SA (subadultna)</option>
                            <option value="N(neodređeno)">N (neodređeno)</option>
                        </select>
                    </div>    
                </div>  
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Način držanja - solitarno/grupa</label>
                        <select class="form-control" name="solitary_or_group" required>
                            <option value="">------</option>
                            @foreach ($animalSolitaryGroup as $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div> 
        
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Način držanja: Hibernacija/estivacija</label>
                        <select class="form-control hib_est" name="hib_est" required>
                            <option value="">------</option>
                            <option value="da">Da</option>
                            <option value="ne">Ne</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Interni naziv (Ime)</label>
                        <input type="text" class="form-control" name="interni_naziv">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4">
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
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="animal_found_note" rows="7" required></textarea>
                            </div>              
                        </div> 
                    </div>                 
                </div>

                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Nalaznik</label>
                            <select name="founder_id" class="form-control" required>
                                <option value="">----</option>
                                @foreach ($founderServices as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
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
                            
                            <label>Tko je donio</label>
                            <select class="form-control" id="founder_service" required>
                                <option value="">----</option>
                                @foreach ($founderServices as $item)
                                    <option value="{{$item->id}}" data-href={{ route('reload_founder') }}>
                                        {{$item->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Dodatna napomena</label>
                            <input type="text" name="brought_animal_note" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Učitaj</label>
                            <input type="file" id="brought_animal_file" name="brought_animal_file[]" multiple />
                            <div id="error_brought_animal_file"></div>
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
                            <label>Stanje u kojem je životinja pronađena</label>
                            <select name="status_found" class="form-control" required>
                                <option value="">----</option>
                                @foreach ($stateType as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Opis</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="status_found_desc" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Učitaj</label>
                            <input type="file" id="status_found_file" name="status_found_file[]" multiple />
                            <div id="error_status_found_file"></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Stanje životinje u trenutku zaprimanja u oporavilište</label>
                            <select name="status_receiving" class="form-control" required>
                                <option value="">----</option>
                                @foreach ($stateType as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
            
                        <div class="form-group">
                            <label>Opis</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="status_receiving_desc" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Učitaj</label>
                            <input type="file" id="status_receiving_file" name="status_receiving_file[]" multiple />
                            <div id="error_status_receiving_file"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Razlog zaprimanja životinje u oporavilište</label>
                            <select name="status_reason" class="form-control" required>
                                <option value="">----</option>
                                @foreach ($stateType as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Opis</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" name="reason_desc" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Učitaj</label>
                            <input type="file" id="reason_file" name="reason_file[]" multiple />
                            <div id="error_reason_file"></div>
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