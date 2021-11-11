@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<ul class="nav shelter-nav">
  <li class="nav-item">
    <a class="nav-link active" href="{{ route('shelter.show', $shelter->id) }}">Oporavilište</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelter.shelter_staff', $shelter->id) }}">Odgovorne osobe</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelters.accomodations.index', [$shelter->id]) }}">Smještajne jedinice</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelters.nutritions.index', [$shelter->id]) }}">Hranjenje životinja</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('shelters.equipments.index', [$shelter->id]) }}">Oprema, transport</a>
  </li>

</ul>

    <div class="d-flex align-items-center justify-content-between">
      <div> <h5 class="mb-3 mb-md-0">{{ $shelter->name }}</h5></div>
      <div>      
        <a type="button" class="btn btn-warning btn-icon-text" data-toggle="modal" 
          data-target="#createCareStaffModal">
            Korisnici aplikacije
            <i class="btn-icon-append" data-feather="user-plus"></i>
          </a>                      
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
           <div><h6 class="card-title">Podaci oporavilišta</h6> </div> 
           <a href="{{ route('shelter.edit', $shelter->id) }}" class="btn btn-primary btn-icon-text" type="button" class="btn btn-primary btn-icon-text">
            Izmjeni podatke
             <i class="btn-icon-append" data-feather="box"></i>
           </a>
            </div>       
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
                    @foreach ($shelter->shelterTypes as $type)
                      <p class="text-muted">
                        {{ $type->name ?? '' }}
                      </p>
                    @endforeach
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
          <div class="card-body">
            <div class="d-flex align-items-center justify-content-between">
              <div><h6 class="card-title">Jedinke u oporavilištu</h6> </div>
              <div class="grid-margin">
                <a href="{{ route('animal.create') }}" type="button" class="btn btn-primary btn-icon-text">
                  Dodaj jedinku
                  <i class="btn-icon-append" data-feather="activity"></i>
                </a>
              </div>
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
                    <th>Dolazak životinje</th>
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

   

@endsection


@push('custom-scripts')
 
@endpush