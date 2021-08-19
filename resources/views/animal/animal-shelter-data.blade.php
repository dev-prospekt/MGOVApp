@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"></a></li>
    <li class="breadcrumb-item active" aria-current="page">Aktivno</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title"></h6>
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
                <tr>
                  <td>{{ $animal->id }}</td>
                  <td>{{ $animal->name }}</td>
                  <td>{{ $animal->latin_name }}</td>
                </tr>
                                                 
              @endforeach                                
              </tbody>
            </table>
        </div>
      </div>
    </div>  
  </div>

  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title"></h6>
        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
        <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>            
                  <th>NAĐENO - LOKACIJA</th>
                  <th>NAĐENO - STATUS</th>         
                </tr>
              </thead>
              <tbody>    
              @foreach ($animalUnit[0]->animalShelterData as $animal)                        
                  <tr>
                    <td>{{ $animal->location }}</td>
                    <td>{{ $animal->found_desc }}</td>
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