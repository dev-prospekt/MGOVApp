<div class="card">
    <div class="card-body">  
        <form action="{{ route('shelterAnimal.invasiveStore') }}" method="POST" enctype="multipart/form-data">
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
                            <option value="">Odaberi</option>
                            <option value="M(mužjak)">M (mužjak)</option>
                            <option value="Ž/F(ženka)">Ž/F (ženka)</option>
                            <option value="N(nije moguće odrediti)">N (nije moguće odrediti)</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Dob jedinke</label>
                        <select class="form-control" name="animal_age" id="" required>
                            <option value="">Odaberi</option>
                            <option value="ADL(adultna)">ADL (adultna)</option>
                            <option value="JUV(juvenilna)">JUV (juvenilna)</option>
                            <option value="SA(subadultna)">SA (subadultna)</option>
                            <option value="N(neodređeno)">N (neodređeno)</option>
                        </select>
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
                            <label>Lokacija pronalaska</label>
                            <input type="text" class="form-control" name="location" required>
                        </div>

                        <div class="form-group">
                            <label>Lokacija preuzimanja životinje</label>
                            <select class="form-control" name="location_retrieval_animal" id="" required>
                                <option value="">Odaberi</option>
                                <option value="u_oporavilistu">U oporavilištu</option>
                                <option value="izvan_oporavilista">Izvan oporavilišta</option>
                                <option value="preuzeli_djelatnici_oporavilista">Preuzeli djelatnici oporavilišta</option>
                                <option value="preuzela_druga_sluzba">Preuzela druga služba</option>
                            </select>
                        </div> 

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
                <div class="col-md-4">
                    <div class="bordered-group">
                        <div class="form-group">
                            <label>Nalaznik</label>
                            <select name="founder_id" class="form-control">
                                <option value="">----</option>
                                @foreach ($founders as $founder)
                                    <option value="{{$founder->id}}">
                                        {{$founder->name}} {{$founder->lastname}} 
                                        @if($founder->service != 'ostalo-navesti:')
                                            ({{$founder->service}})
                                        @else
                                            ({{$founder->others}})
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
                            <label>Eutanazija</label>
                            <select class="form-control euthanasia_select" name="euthanasia_select" required>
                                <option value="">------</option>
                                <option value="da">Da</option>
                                <option value="ne">Ne</option>
                            </select>
                        </div>
                        <div class="form-group" id="euthanasia">
                            <label>Učitaj račun</label>
                            <input type="file" id="euthanasia_invoice" name="euthanasia_invoice[]" multiple />
                            <div class="mb-2" id="error_euthanasia_invoice"></div>
                
                            <label>Iznos</label>
                            <input type="text" class="form-control" name="euthanasia_ammount">
                            
                        </div>
                    </div>

                    <div class="bordered-group mt-2">
                        <div class="form-group">
                            <label>Tko je donio</label>
                            <select name="brought_animal" class="form-control">
                                <option value="">----</option>
                                @foreach ($founders as $founder)
                                    <option value="{{$founder->id}}">
                                        {{$founder->name}} {{$founder->lastname}} 
                                        @if($founder->service != 'ostalo-navesti:')
                                            ({{$founder->service}})
                                        @else
                                            ({{$founder->others}})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Učitaj</label>
                            <input type="file" id="brought_animal_file" name="brought_animal_file[]" multiple />
                            <div id="error_brought_animal_file"></div>
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