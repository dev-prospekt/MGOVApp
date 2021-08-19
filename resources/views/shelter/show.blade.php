@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">{{ $shelter[0]->name }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">Aktivno</li>
  </ol>
</nav>

<div class="row">



  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">{{ $shelter[0]->name }}</h6>
        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NAZIV OPORAVILIŠTA</th>
                  <th>ADRESA OPORAVILIŠTA</th>
                  <th>OIB</th>
                  <th>ADMINISTRATOR</th>
                  <th>AKCIJA</th>
                </tr>
              </thead>
              <tbody>        
                <tr>
                  <th>{{ $shelter[0]->id }}</th>
                  <td>{{ $shelter[0]->name  }}</td>
                  <td>{{ $shelter[0]->address }}</td>
                  <td>{{ $shelter[0]->oib }}</td>
                  <td>{{ auth()->user()->email }}</td>
                  
                  <td><a class="btn btn-primary btn-icon" href="#" role="button"><i data-feather="check-square"></i></a>
                    <a class="btn btn-danger btn-icon" href="#" role="button">  <i data-feather="box"></i></a></td>
                </tr>   
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Korisnici</h6>
        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Ime i prezime</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>           
              @foreach ($shelter as $shelterUser)
               @foreach ($shelterUser->users as $user)
               <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
              </tr>
               @endforeach        
                @endforeach                                                                         
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>

</div>


<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">{{ $shelter[0]->name }}</h6>
        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>NAZIV VRSTE</th>
                  <th>LATINSKI NAZIV</th>
                  <th>INFO</th>
                </tr>
              </thead>
              <tbody>      
              @foreach ($animalUnit as $animal)
                @foreach ($animal->animalShelterData as $shelterData)
                <tr>
                  <td>{{ $animal->id }}</td>
                  <td>{{ $animal->name }}</td>
                  <td>{{ $animal->latin_name }}</td>
                  <td> @isset($shelterData->id)
                    <a  class="btn btn-primary btn-icon-text" href="{{ route('animal_shelter_data.show', [$shelterData->id]) }}">
                      <i class="btn-icon-prepend" data-feather="check-square"></i>
                      Podaci životnje
                    </a>
                  @endisset</td>
                </tr>
                @endforeach                                    
              @endforeach                                
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection