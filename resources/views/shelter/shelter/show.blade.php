@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">{{ $shelter->name ?? '' }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Aktivno</li>
  </ol>
</nav>

<div class="row">
    <div class="col-md-8 grid-margin">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">{{ $shelter->name ?? '' }}</h6>
          <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NAZIV OPORAVILIŠTA</th>
                  <th>ADRESA OPORAVILIŠTA</th>
                  <th>Oib</th>
                  <th>EMAIL</th>
                  <th>ADministrator</th>
                  <th>Ovlašteno</th>
                </tr>
              </thead>
              <tbody>                
                <tr>
                  <td>{{ $shelter->id ?? '' }}</td>
                  <td>{{ $shelter->name ?? '' }}</td>                 
                  <td>{{ $shelter->address ?? ''  }}</td>
                  <td>{{ $shelter->oib ?? ''  }}</td>
                  <td>{{ $shelter->email ?? ''  }}</td>
                  <td>{{ $shelter->users()->first()->name ?? ''  }}</td>        
                  <td>@foreach ($shelter->shelterTypes as $type)
                    <button type="button" class="btn btn-{{ $type->id == 1 ? 'warning' : 'danger' }}" data-toggle="tooltip" data-placement="left" title="{{ $type->name }}">
                      {{ $type->code }}
                    </button>
                  @endforeach</td> 
                </tr>    
            </table>
        </div>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-body">
          
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h6 class="card-title">Popis životinja u oporavilištu</h6>
              <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
            </div>
            <div>
              <a href="{{ route('animal.create') }}" class="btn btn-primary">Dodaj</a>
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
                  <th>Code</th>
                  <th>Pronađeno</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>

                @foreach ($shelter->animals as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="badge badge-secondary">{{ $item->pivot->quantity }}</span></td>
                    <td>{{ $item->pivot->shelterCode }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->latin_name }}</td>
                    <td>
                      @foreach ($item->animalCodes as $code)
                        <span class="badge badge-warning">{{ $code->name }}</span>
                      @endforeach
                    </td>
                    <td>{{ $item->animalItems->first()->date_find }}</td>
                    <td>
                      <a class="btn btn-info" href="/shelter/{{$item->pivot->shelter_id}}/animal/{{$item->pivot->shelterCode}}">
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

    <div class="col-md-4 grid-margin">
      <div class="card rounded">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <h6 class="card-title mb-0">Ostali Podaci</h6>
            
          </div>
            <div class="row">
              <div class="col-md-6 grid-margin">
              
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon: </label>
                    <p class="text-muted">{{ $shelter->telephone ?? '' }}</p>
                  </div>
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Fax:</label>
                    <p class="text-muted">{{ $shelter->fax ?? '' }}</p>
                  </div>
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel:</label>
                    <p class="text-muted">{{ $shelter->mobile ?? '' }}</p>
                  </div>
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Web stranica:</label>
                    <p class="text-muted">{{ $shelter->web_address ?? '' }}</p>
                  </div>
              </div> 

              <div class="col-md-6 grid-margin">

                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Banka: </label>
                  <p class="text-muted">{{ $shelter->bank_name ?? '' }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">IBAN</label>
                  <p class="text-muted">{{ $shelter->iban ?? '' }}</p>         
                </div> 
                <div class="mt-3">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">OVLAŠTENJE: </label>
                  <p class="text-muted">
                    @foreach ($shelter->shelterTypes as $type)
                    {{ $type->name ?? '' }}
                    @endforeach
                  </p>
                </div>
              </div>             
          </div>
      </div>
    </div>     
    
    <div class="card rounded mt-4">
      <div class="card-body">
        <h6 class="card-title">Korisnici Oporavilišta</h6>        
        @foreach ($shelter->users as $user)   
          <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
            <div class="d-flex align-items-center hover-pointer">
              <img class="img-xs rounded-circle" src="{{ url('https://via.placeholder.com/37x37') }}" alt="">													
              <div class="ml-2">
                <p>{{ $user->name }} | {{ $user->email ?? ''}}</p>
                <p class="tx-11 text-muted">{{ $user->roles()->first()->name ?? ''}}</p>
              </div>
            </div>
            <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip" title="Connect"></i></button>
          </div>
        @endforeach              
      </div>
    </div>
    
  </div> 
</div>
@endsection