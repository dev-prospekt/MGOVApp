@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<ul class="nav shelter-nav">
  <li class="nav-item">
    <a class="nav-link active" href="#">Podaci o korisnicima</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelter_accomodation', [$shelter->id, 'shelter' => $shelter->id]) }}">Nastambe oporavilišta</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Oprema, prehrana</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Korisnici aplikacije</a>
  </li>

</ul>

    <div class="d-flex align-items-center justify-content-between">
      <div></div>
      <div>      
          <a href="javascript:void(0)" class="btn btn-primary btn-icon-text" data-toggle="modal" 
          data-target="#createStaffModal" type="button" class="btn btn-primary btn-icon-text">
            Odgovorna osoba - pravna osoba
            <i class="btn-icon-append" data-feather="user-plus"></i>
          </a>
    
          <a type="button" class="btn btn-warning btn-icon-text" data-toggle="modal" 
          data-target="#createCareStaffModal">
            Odgovorna osoba - skrb životinja
            <i class="btn-icon-append" data-feather="user-plus"></i>
          </a>
    
          <a type="button" class="btn btn-info btn-icon-text" data-toggle="modal" data-target="#createVetStaffModal">
            Pružatelj veterinarske usluge
            <i class="btn-icon-append" data-feather="plus-circle"></i>
          </a>               
      </div>
    </div>

    @if($msg = Session::get('finishMSG'))
    <div id="successMessage" class="alert alert-success mt-3"> {{ $msg }}</div>
    @endif
   
    <div class="row mt-4">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title">{{ $shelter->name ?? '' }}</h6>
            <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>          
              <div class="row">
                <div class="col-md-4 grid-margin">    
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv: </label>
                      <p class="text-muted">{{ $shelter->name ?? '' }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa sjedišta:</label>
                      <p class="text-muted">{{ $shelter->address ?? '' }}</p>
                    </div>
  
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mjesto i poštanski broj:</label>
                      <p class="text-muted">{{ $shelter->place_zip ?? '' }}</p>
                    </div>
  
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa lokacije:</label>
                      <p class="text-muted">{{ $shelter->address ?? '' }}</p>
                    </div>
                    <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
                      <p class="text-muted">{{ $shelter->oib ?? '' }}</p>
                    </div>           
                </div> 
  
                <div class="col-md-4 grid-margin">
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                    <p class="text-muted">{{ $shelter->email ?? '' }}</p>
                  </div>
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon: </label>
                    <p class="text-muted">{{ $shelter->telephone ?? '' }}</p>
                  </div>
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Fax:</label>
                    <p class="text-muted">{{ $shelter->fax ?? '' }}</p>
                  </div>
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel:</label>
                    <p class="text-muted">{{ $shelter->mobile ?? '' }}</p>
                  </div>
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Web stranica:</label>
                    <p class="text-muted">{{ $shelter->web_address ?? '' }}</p>
                  </div>
                </div> 
  
                <div class="col-md-4 grid-margin">
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Banka: </label>
                    <p class="text-muted">{{ $shelter->bank_name ?? '' }}</p>
                  </div>
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">IBAN</label>
                    <p class="text-muted">{{ $shelter->iban ?? '' }}</p>         
                  </div> 
                  <div class="mt-2">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">OVLAŠTENJE: </label>
                    <p class="text-muted">
                      @foreach ($shelter->shelterTypes as $type)
                      {{ $type->name ?? '' }}
                      @endforeach
                    </p>
                  </div>
  
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">DATUM REGISTRACIJE: </label>
                    <p class="text-muted">{{ $shelter->register_date ?? '' }}</p>  
                  </div>
  
                  <div class="mt-2">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">ŠIFRA OPORAVILIŠTA: </label>
                    <p class="text-muted">{{ $shelter->shelter_code ?? '' }}</p>  
                  </div>
                </div>       
            </div>         
          </div>
        </div>
      </div>
      
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body ">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <h6 class="card-title">Pravno Odgovorna osoba </h6>        
          </div>
          <div>
            @if ($shelterLegalStaff)
            <button type="button" class="btn btn-primary btn-icon"  data-id="{{ $shelterLegalStaff->id ?? ''  }}"  data-toggle="modal" data-target="#editStaffLegalModal">
              <i data-feather="check-square"></i>
            </button>        
              <button type="button" id="deleteLegalStaff" type="button" class="btn btn-danger btn-icon" 
              data-id="{{ $shelterLegalStaff->id ?? ''  }}">
                <i data-feather="box"></i>
              </button>
              @endif       
          </div>
        </div> 
        <div class="row">
       
          <div class="col-md-4 grid-margin">  
           
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ime i prezime: </label>
              <p class="text-muted">{{ $shelterLegalStaff->name ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
              <p class="text-muted">{{ $shelterLegalStaff->oib ?? '' }}</p>
            </div>
  
             
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa prebivališta:</label>
              <p class="text-muted">{{ $shelterLegalStaff->address ?? '' }}</p>
            </div>                     
          </div> 
  
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa Boravišta</label>
              <p class="text-muted">{{ $shelterLegalStaff->address_place ?? '' }}</p>
            </div> 
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon:</label>
              <p class="text-muted">{{ $shelterLegalStaff->phone ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel: </label>
              <p class="text-muted">{{ $shelterLegalStaff->phone_cell ?? '' }}</p>
            </div>
                
          </div> 
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
              <p class="text-muted">{{ $shelterLegalStaff->email ?? '' }}</p>
            </div>
  
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Uvjerenje protiv kaznenog postupka:</label>        
                <div class="d-md-block mt-2">
                    @if ($fileLegal)
                    <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $fileLegal->getUrl() }}"> {{ $fileLegal->file_name }}  </a>
                    @endif     
                </div>
            </div>
          </div>       
        </div>       
      </div>
    </div> 
  
    <div class="card mt-4">
      <div class="card-body ">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <h6 class="card-title">Osoba odgovorna za skrb životinja</h6>        
          </div>
          <div>
            @if ($shelterCareStaff)
            <button type="button" class="btn btn-primary btn-icon"  data-id="{{ $shelterCareStaff->id ?? ''  }}"  data-toggle="modal" data-target="#editStaffCareModal">
              <i data-feather="check-square"></i>
            </button>        
              <button type="button" id="deleteCareStaff" type="button" class="btn btn-danger btn-icon" 
              data-id="{{ $shelterCareStaff->id ?? ''  }}">
                <i data-feather="box"></i>
              </button>
              @endif       
          </div>
        </div> 
        <div class="row">
          <div class="col-md-4 grid-margin">   
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ime i prezime: </label>
              <p class="text-muted">{{ $shelterCareStaff->name ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
              <p class="text-muted">{{ $shelterCareStaff->oib ?? '' }}</p>
            </div>
  
             
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa prebivališta:</label>
              <p class="text-muted">{{ $shelterCareStaff->address ?? '' }}</p>
            </div>                     
          </div> 
  
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa Boravišta</label>
              <p class="text-muted">{{ $shelterCareStaff->address_place ?? '' }}</p>
            </div> 
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon:</label>
              <p class="text-muted">{{ $shelterCareStaff->phone ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel: </label>
              <p class="text-muted">{{ $shelterCareStaff->phone_cell ?? '' }}</p>
            </div>
                
          </div> 
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
              <p class="text-muted">{{ $shelterCareStaff->email ?? '' }}</p>
            </div>
  
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Stručna sprema i struka:</label>
              <p class="text-muted">{{ $shelterCareStaff->education ?? '' }}</p>
            </div>
  
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Kopija ugovora o radu ili drugog sporazuma:</label>        
                <div class="d-md-block mt-2">
                    @if ($fileContract)
                    <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $fileContract->getUrl() }}"> {{ $fileContract->file_name }}  </a>
                    @endif     
                </div>
            </div>
          </div>  
          
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Dokaz o odgovarajućoj osposobljenosti:</label>        
                <div class="d-md-block mt-2">
                    @if ($fileCertificate)
                    <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $fileCertificate->getUrl() }}"> {{ $fileCertificate->file_name }}  </a>
                    @endif     
                </div>
            </div>
          </div>
          <div class="col-md-8 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Opis prethodnog radnog iskustva:</label>
              <p class="text-muted">{{ $shelterCareStaff->education ?? '' }}</p>
            </div>
  
          </div>
        </div>       
      </div>
    </div> 
  
  
    <div class="card mt-4">
      <div class="card-body ">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <h6 class="card-title">Podaci o pružatelju veterinarske usluge</h6>        
          </div>
          <div>
            @if ($shelterVetStaff)
              @if ($fileVetAmbulance )
              <button type="button" class="btn btn-primary btn-icon"  data-id="{{ $shelterVetStaff->id ?? ''  }}"  data-toggle="modal" data-target="#editAmbulanceModal">
                <i data-feather="check-square"></i>
              </button> 
              @else
              <button type="button" class="btn btn-primary btn-icon"  data-id="{{ $shelterVetStaff->id ?? ''  }}"  data-toggle="modal" data-target="#editVetStaffModal">
                <i data-feather="check-square"></i>
              </button> 
              @endif
             
              <button type="button" id="deleteVetStaff" type="button" class="btn btn-danger btn-icon" 
              data-id="{{ $shelterVetStaff->id ?? ''  }}">
                <i data-feather="box"></i>
              </button>
              @endif       
          </div>
        </div> 
        <div class="row">
          <div class="col-md-4 grid-margin">   
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ime i prezime/Naziv ustanove: </label>
              <p class="text-muted">{{ $shelterVetStaff->name ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
              <p class="text-muted">{{ $shelterVetStaff->oib ?? '' }}</p>
            </div>
  
             
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa prebivališta:</label>
              <p class="text-muted">{{ $shelterVetStaff->address ?? '' }}</p>
            </div>                     
          </div> 
  
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa Boravišta</label>
              <p class="text-muted">{{ $shelterVetStaff->address_place ?? '' }}</p>
            </div> 
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon:</label>
              <p class="text-muted">{{ $shelterVetStaff->phone ?? '' }}</p>
            </div>
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel: </label>
              <p class="text-muted">{{ $shelterVetStaff->phone_cell ?? '' }}</p>
            </div>
                
          </div> 
          <div class="col-md-4 grid-margin">
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
              <p class="text-muted">{{ $shelterVetStaff->email ?? '' }}</p>
            </div>
  
            @if ($fileVetContract)
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Kopija ugovora o radu ili drugog sporazuma:</label>        
                <div class="d-md-block mt-2">        
                    <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $fileVetContract->getUrl() }}"> {{ $fileVetContract->file_name }}  </a>             
                </div>
            </div>
            @endif 
  
            @if ($fileVetDiploma)
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Kopija diplome doktora:</label>        
                <div class="d-md-block mt-2">            
                    <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $fileVetDiploma->getUrl() }}"> {{ $fileVetDiploma->file_name }}  </a>             
                </div>
            </div>
            @endif
  
            @if ($fileVetAmbulance)
            <div class="mt-2">
              <label class="tx-11 font-weight-bold mb-0 text-uppercase">Kopija ugovora ili drugog sporazuma - vanjski pružatelj usluge</label>        
                <div class="d-md-block mt-2">        
                    <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $fileVetAmbulance->getUrl() }}"> {{ $fileVetAmbulance->file_name }}  </a>            
                </div>
            </div>
            @endif 
          </div>  
     
        </div>       
      </div>
    </div>
  
  
  </div>
  </div> 

  <!-- end row -->
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">  
      <div class="card rounded">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h6 class="card-title">Ostale osobe za skrb životinja</h6>        
              </div>
              <div>        
                <a type="button" class="btn btn-info btn-icon-text" data-toggle="modal" data-target="#createPersonelStaffModal">
                  Dodaj<i class="btn-icon-append" data-feather="user-plus"></i>
                </a>                      
              </div>
            </div> 
            
              <div class="table-responsive mt-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Ime  i prezime</th>
                        <th>OIB</th>
                        <th>Adresa Prebivališta</th>
                        <th>Adresa boravišta</th>
                        <th>Telefon</th>
                        <th>Mobitel</th>
                        <th>Email</th>
                        <th>Stručna sprema</th>
                        <th>Akcija</th>
                    </tr>
                    </thead>
                    <tbody>
                      @if ($shelterPersonelStaff)
                      
                      @foreach($shelterPersonelStaff as $staff)   
                      <tr>
                        <td>{{ $staff->name }}</td>
                        <td>{{ $staff->oib }}</td>
                        <td>{{ $staff->address }}</td>
                        <td>{{ $staff->address_place }}</td>
                        <td>{{ $staff->phone }}</td>
                        <td>{{ $staff->phone_cell }}</td>
                        <td>{{ $staff->email }}</td>
                        <td>{{ $staff->education }}</td>
                      
                        <td><button type="button" class="btn btn-primary btn-icon"  data-id="{{ $staff->id ?? ''  }}"  data-toggle="modal" data-target="#editStaffPersonelModal">
                          <i data-feather="check-square"></i>
                        </button>        
                        <button type="button" id="deletePersonelStaff" type="button" class="btn btn-danger btn-icon" 
                          data-id="{{ $staff->id ?? ''  }}">
                            <i data-feather="box"></i>
                          </button></td>
                      </tr>
                      @endforeach
                    
                      @endif
                    </tbody>
                </table>
              </div>          
                
          </div>
        </div>
      </div> 
  </div>

  <div class="row">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
  
          <h6 class="card-title">Životinje u oporavilištu</h6> 
  
          <div class="grid-margin">
            <a href="{{ route('animal.create') }}" class="btn btn-primary">Dodaj</a>
          </div>
  
          @if($msg = Session::get('msg'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif
  
          <div class="table-responsive">
            <table id="shelterAnimalTable" class="table">
              <thead>          
                <tr>
                  <th>#</th>
                  <th>Ukupno</th>
                  <th>Šifra</th>
                  <th>Naziv jedinke</th>
                  <th>Latinski naziv</th>
                  <th>Oznaka</th>
                  <th>Tip jedinke</th>
                  <th>Pronađeno</th>
                  <th>Upisano</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
  
                @foreach ($shelter->animals as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-secondary">{{ $item->pivot->quantity }}</span></td>
                    <td>{{ $item->pivot->shelter_code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->latin_name }}</td>
                    <td>
                      @foreach ($item->animalCodes as $code)
                        <span class="badge badge-danger">{{ $code->name }}</span>
                      @endforeach
                    </td>
                    <td>
                      @foreach ($item->animalType as $res)
                      <span class="badge badge-warning">{{ $res->type_code }}</span>
                      @endforeach
                    </td>
                    <td>{{ $item->animalItems->first()->date_found ?? '' }}</td>
                    <td>{{ date('H:i - d.m.Y', strtotime($item->pivot->created_at)) }}</td>
                    <td>
                      <a class="btn btn-info" href="/shelter/{{$item->pivot->shelter_id}}/animal/{{$item->pivot->shelter_code}}">
                        Info
                      </a>
                    </td>
                  </tr>
                @endforeach
  
              </tbody>                
            </table>
          </div>
  
        </div>
      </div>
    </div>
  </div>

{{-- Create Legal Staff Modal --}}
@include('shelter.shelter.shelter_staff_legal._create')

{{-- Update Legal Staff Modal --}}
@include('shelter.shelter.shelter_staff_legal._update')

{{-- Create Care Staff Modal --}}
@include('shelter.shelter.shelter_staff_care._create')
{{-- Update Legal Staff Modal --}}
@include('shelter.shelter.shelter_staff_care._update')

{{-- Create Vet Staff Modal --}}
@include('shelter.shelter.shelter_staff_vet._create')

{{-- Update Vet Staff Modals --}}
@include('shelter.shelter.shelter_staff_vet._update')
@include('shelter.shelter.shelter_staff_vet._update-ambulance')

{{-- Create Personel Staff Modal --}}
@include('shelter.shelter.shelter_staff_personel._create')
{{-- Update Personel Staff Modal --}}
@include('shelter.shelter.shelter_staff_personel._update')


@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/file-upload.js') }}"></script>

<script>

      $(function() {
           
        // Create Legal Shelter Staff Ajax request.
        $('#createLegalStaff').on('submit', function(e) {
          e.preventDefault();

          var legalForm = this;
          var alertDanger = $('#dangerLegalStaffCreate');
          var alertSuccess = $('#successLegalStaffCreate');
        
          $.ajax({
              url: $(legalForm).attr('action'),
              method: 'POST',
              data: new FormData(legalForm),
              processData: false,
              dataType: 'json',
              contentType: false,

              success: function(result) {
                console.log(result);
                
                  if(result.errors) {
                      alertDanger.html('');
                      console.log(result);
                      $.each(result.errors, function(key, value) {
                          alertDanger.show();
                          alertDanger.append('<strong><li>'+value+'</li></strong>');
                      });
                  } else {
                      alertDanger.hide();
                      alertSuccess.show();
      
                      setInterval(function(){ 
                          alertSuccess.hide();
                          $('#createStaffLegalModal').modal('hide');
                          location.reload();
                      }, 2000);
                  }
              }
          });
        });
        
        // Update Legal Shelter Staff Ajax request.
        $('#updateLegalStaff').on('submit', function(e) {
            e.preventDefault();
            var updateLegalForm = this;
            var alertDanger = $('#dangerLegalStaffUpdate');
            var alertSuccess = $('#successLegalStaffUpdate');
          
            $.ajax({
                url: $(updateLegalForm).attr('action'),
                method: 'POST',
                data: new FormData(updateLegalForm),
                processData: false,
                dataType: 'json',
                contentType: false,

                success: function(result) {
                console.log(result);
                  
                    if(result.errors) {
                        alertDanger.html('');
                        console.log(result);
                        $.each(result.errors, function(key, value) {
                            alertDanger.show();
                            alertDanger.append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                    
                        alertDanger.hide();
                        alertSuccess.show();
        
                        setInterval(function(){ 
                            alertDanger.hide();
                            $('#editStaffLegalModal').modal('hide');
                            location.reload();
                            console.log(result);
                        }, 2000);
                    }
                }
            });
        });

        // Delete legal Staff
        $('body').on('click', '#deleteLegalStaff', function() {

          deleteID = $(this).data('id');
          
          Swal.fire({
              title: "Brisanje?",
              text: "Potvrdite ako ste sigurni za brisanje Osobe!",
              type: "warning",
              showCancelButton: !0,
              confirmButtonText: "Da, brisanje!",
              cancelButtonText: "Ne, odustani!",
              reverseButtons: !0
          }).then(function (e) {
              if (e.value === true) {           
                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
            
                });
                $.ajax({
                    type: 'DELETE',
                    url: "{{url('/shelter_legal_staff')}}/" + deleteID,
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

            // Create Care Staff
            $('#createCareStaff').on('submit', function(e) {
              e.preventDefault();

              var careForm = this;
              var alertDanger = $('#dangerCareStaffCreate');
              var alertSuccess = $('#successCareStaffCreate');
            
              $.ajax({
                  url: $(careForm).attr('action'),
                  method: 'POST',
                  data: new FormData(careForm),
                  processData: false,
                  dataType: 'json',
                  contentType: false,

                  success: function(result) {
                    console.log(result);
                  
                    if(result.errors) {
                        alertDanger.html('');
                        $.each(result.errors, function(key, value) {
                            alertDanger.show();
                            alertDanger.append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        alertDanger.hide();
                        alertSuccess.show();
        
                        setInterval(function(){ 
                            $('.alert-success').hide();
                            $('#createStaffCareModal').modal('hide');
                            location.reload();
                        }, 2000);
                    }
                  }
              });
            });

            // Update Legal Shelter Staff Ajax request.
            $('#updateCareStaff').on('submit', function(e) {
              e.preventDefault();
              var updateCareForm = this;
              var alertDanger = $('#dangerCareStaffUpdate');
              var alertSuccess = $('#successCareStaffUpdate');
            
              $.ajax({
                  url: $(updateCareForm).attr('action'),
                  method: 'POST',
                  data: new FormData(updateCareForm),
                  processData: false,
                  dataType: 'json',
                  contentType: false,

                  success: function(result) {
                  console.log(result);
                    
                      if(result.errors) {
                          alertDanger.html('');
                          console.log(result);
                          $.each(result.errors, function(key, value) {
                              alertDanger.show();
                              alertDanger.append('<strong><li>'+value+'</li></strong>');
                          });
                      } else {
                      
                          alertDanger.hide();
                          alertSuccess.show();
          
                          setInterval(function(){ 
                              alertDanger.hide();
                              $('#editStaffCareModal').modal('hide');
                              console.log(result)
                              location.reload();
                              ;
                          }, 2000);
                      }
                  }
              });
            });

            // Delete care Staff
            $('body').on('click', '#deleteCareStaff', function() {

              deleteID = $(this).data('id');

              Swal.fire({
                  title: "Brisanje?",
                  text: "Potvrdite ako ste sigurni za brisanje Osobe!",
                  type: "warning",
                  showCancelButton: !0,
                  confirmButtonText: "Da, brisanje!",
                  cancelButtonText: "Ne, odustani!",
                  reverseButtons: !0
              }).then(function (e) {

              if (e.value === true) {
                              
                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }

              });
                $.ajax({
                    type: 'DELETE',
                    url: "{{url('/shelter_legal_staff')}}/" + deleteID,
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

            // Vet Staff - show fields
            $('.staff_vet_type').click(function(){
              var inputValue = $(this).attr("value");
              var targetBox = $("." + inputValue);
              $(".staff_form_group").not(targetBox).hide();
              $(targetBox).show();
            });

            // Create VET Shelter Staff Ajax request.
            $('#createVetStaff').on('submit', function(e) {
                      e.preventDefault();

                      var vetForm = this;
                      var alertDanger = $('#dangerVetStaffCreate');
                      var alertSuccess = $('#successVetStaffCreate');
                    
                      $.ajax({
                          url: $(vetForm).attr('action'),
                          method: 'POST',
                          data: new FormData(vetForm),
                          processData: false,
                          dataType: 'json',
                          contentType: false,

                          success: function(result) {
                            console.log(result);
                            
                              if(result.errors) {
                                  alertDanger.html('');
                                  console.log(result);
                                  $.each(result.errors, function(key, value) {
                                      alertDanger.show();
                                      alertDanger.append('<strong><li>'+value+'</li></strong>');
                                  });
                              } else {
                                  alertDanger.hide();
                                  alertSuccess.show();
                  
                                  setInterval(function(){ 
                                      alertSuccess.hide();
                                      $('#createVetStaffModal').modal('hide');
                                      location.reload();
                                  }, 2000);
                              }
                          }
                      });
                });

                // Update Ambulance Shelter Staff Ajax request.
                $('#updateAmbulanceStaff').on('submit', function(e) {
                    e.preventDefault();
                    var updateAmbulanceForm = this;
                    var alertDanger = $('#dangerAmbulanceUpdate');
                    var alertSuccess = $('#successAmbulanceUpdate');
                  
                    $.ajax({
                        url: $(updateAmbulanceForm).attr('action'),
                        method: 'POST',
                        data: new FormData(updateAmbulanceForm),
                        processData: false,
                        dataType: 'json',
                        contentType: false,

                        success: function(result) {
                        console.log(result);
                          
                            if(result.errors) {
                                alertDanger.html('');
                                console.log(result);
                                $.each(result.errors, function(key, value) {
                                    alertDanger.show();
                                    alertDanger.append('<strong><li>'+value+'</li></strong>');
                                });
                            } else {
                            
                                alertDanger.hide();
                                alertSuccess.show();
                
                                setInterval(function(){ 
                                    alertDanger.hide();
                                    $('#editAmbulanceModal').modal('hide');
                                    location.reload();
                                    console.log(result);
                                }, 2000);
                            }
                        }
                    });
                });


                 // Update Vet Shelter Staff Ajax request.
                 $('#updateVetStaff').on('submit', function(e) {
                    e.preventDefault();
                    var updateVetForm = this;
                    var alertDanger = $('#dangerVetStaffUpdate');
                    var alertSuccess = $('#successVetStaffUpdate');
                  
                    $.ajax({
                        url: $(updateVetForm).attr('action'),
                        method: 'POST',
                        data: new FormData(updateVetForm),
                        processData: false,
                        dataType: 'json',
                        contentType: false,

                        success: function(result) {
                        console.log(result);
                          
                            if(result.errors) {
                                alertDanger.html('');
                                console.log(result);
                                $.each(result.errors, function(key, value) {
                                    alertDanger.show();
                                    alertDanger.append('<strong><li>'+value+'</li></strong>');
                                });
                            } else {
                            
                                alertDanger.hide();
                                alertSuccess.show();
                
                                setInterval(function(){ 
                                    alertDanger.hide();
                                    $('#editVetStaffModal').modal('hide');
                                    location.reload();
                                    console.log(result);
                                }, 2000);
                            }
                        }
                    });
                });

                    // Delete care Staff
            $('body').on('click', '#deleteVetStaff', function() {

                deleteID = $(this).data('id');

                Swal.fire({
                    title: "Brisanje?",
                    text: "Potvrdite ako ste sigurni za brisanje Osobe!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Da, brisanje!",
                    cancelButtonText: "Ne, odustani!",
                    reverseButtons: !0
                }).then(function (e) {

                if (e.value === true) {
                                
                  $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }

                });
                  $.ajax({
                      type: 'DELETE',
                      url: "{{url('/shelter_vet_staff')}}/" + deleteID,
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

                // Create Personel Shelter Staff Ajax request.
                $('#createPersonelStaff').on('submit', function(e) {
                e.preventDefault();

                var personelForm = this;
                var alertDanger = $('#dangerPersonelStaffCreate');
                var alertSuccess = $('#successPersonelStaffCreate');
                    
                      $.ajax({
                          url: $(personelForm).attr('action'),
                          method: 'POST',
                          data: new FormData(personelForm),
                          processData: false,
                          dataType: 'json',
                          contentType: false,

                          success: function(result) {
                            console.log(result);
                            
                              if(result.errors) {
                                  alertDanger.html('');
                                  console.log(result);
                                  $.each(result.errors, function(key, value) {
                                      alertDanger.show();
                                      alertDanger.append('<strong><li>'+value+'</li></strong>');
                                  });
                              } else {
                                  alertDanger.hide();
                                  alertSuccess.show();
                  
                                  setInterval(function(){ 
                                      alertSuccess.hide();
                                      $('#createVetStaffModal').modal('hide');
                                      location.reload();
                                  }, 2000);
                              }
                          }
                      });
                });

                // Update Personel Shelter Staff Ajax request.
              $('#updatePersonelStaff').on('submit', function(e) {
                e.preventDefault();
                var updatePersonelForm = this;
                var alertDanger = $('#dangerPersonelStaffUpdate');
                var alertSuccess = $('#successPersonelStaffUpdate');
              
                $.ajax({
                    url: $(updatePersonelForm).attr('action'),
                    method: 'POST',
                    data: new FormData(updatePersonelForm),
                    processData: false,
                    dataType: 'json',
                    contentType: false,

                    success: function(result) {
                    console.log(result);
                      
                        if(result.errors) {
                            alertDanger.html('');
                            console.log(result);
                            $.each(result.errors, function(key, value) {
                                alertDanger.show();
                                alertDanger.append('<strong><li>'+value+'</li></strong>');
                            });
                        } else {
                        
                            alertDanger.hide();
                            alertSuccess.show();
            
                            setInterval(function(){ 
                                alertDanger.hide();
                                $('#editStaffPersonelModal').modal('hide');
                                console.log(result)
                                location.reload();
                                ;
                            }, 2000);
                        }
                    }
                });
            });

            // Delete legal Staff
            $('body').on('click', '#deletePersonelStaff', function() {

              deleteID = $(this).data('id');

              Swal.fire({
                  title: "Brisanje?",
                  text: "Potvrdite ako ste sigurni za brisanje Osobe!",
                  type: "warning",
                  showCancelButton: !0,
                  confirmButtonText: "Da, brisanje!",
                  cancelButtonText: "Ne, odustani!",
                  reverseButtons: !0
              }).then(function (e) {

              if (e.value === true) {
                              
                $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }

              });
                $.ajax({
                    type: 'DELETE',
                    url: "{{url('/shelter_personel_staff')}}/" + deleteID,
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
 
@endpush