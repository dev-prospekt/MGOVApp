@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
      <h4 class="mb-3 mb-md-0">Dobro došao {{ auth()->user()->name }}</h4>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow">

      <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Ukupni broj jedinki</h6>
              <div class="dropdown mb-2">
                <button class="btn p-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Popis</span></a>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">
                  {{ $shelters->first()->animalItems->count() }}
                </h3>
                <div class="d-flex align-items-baseline">
                  <p class="text-success">
                    <span>+3,3%</span>
                    <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                  </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-2">Učitavanje podataka</h6>
            <p class="card-description">Učitavanje redova, porodica, jedinki (xls)</p>
              <a href="/animal_import" type="button" class="btn btn-primary btn-sm mr-2 mt-2">Pregled</a>
          </div>
        </div>

      </div>

      <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-2">Veličine jedinki</h6>
            <p class="card-description">Popis grupa i pripadajućih cijena</p>
              <a href="/animal_size" type="button" class="btn btn-primary btn-sm mr-2 mt-2">Pregled</a>
          </div>
        </div>

      </div>
      <div class="col-md-3 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h6 class="card-title mb-2">Popis korisnika</h6>
            <p class="card-description">Korisnici vezani za oporavilište</p>
              <a href="/user" type="button" class="btn btn-primary btn-sm mr-2 mt-2">Pregled</a>
          </div>
        </div>

      </div>
    </div>
  </div>
</div> <!-- row -->

<div class="row">
  <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
      <div class="card">
          <div class="card-body">
              
              <div class="d-flex align-items-center justify-content-between">
                  <div>
                      <h6 class="card-title">Oporavilišta za divlje životinje</h6>
                      <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                  </div>
                  <div>
                      <a href="{{ route("shelter.create") }}" class="btn btn-primary btn-sm">Dodaj oporavilište</a>
                  </div>
              </div>

              @if($msg = Session::get('msg'))
              <div class="alert alert-success"> {{ $msg }}</div>
              @endif

              <div class="table-responsive">
              <table class="table">
                  <thead>
                  <tr>
                      <th>#</th>
                      <th>NAZIV OPORAVILIŠTA</th>
                      <th>ADRESA OPORAVILIŠTA</th>
                      <th>EMAIL</th>
                      <th>TELEFON</th>
                      <th>ADMINISTRATOR</th>
                      <th>Ovlašteno</th>
                      <th>AKCIJA</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($shelters as $shelter)
                      <tr>
                          <td>{{ $shelter->id }}</td>
                          <td>{{ $shelter->name }}</td>                 
                          <td>{{ $shelter->address }}</td>
                          <td>{{ $shelter->email }}</td>
                          <td>{{ $shelter->telephone }}</td>
                          <td>{{ $shelter->users->first()->name ?? '' }}</td>
                          <td>
                              @foreach ($shelter->shelterTypes as $type)
                                  <button type="button" class="btn btn-xs btn-{{ $type->id == 1 ? 'warning' : 'danger' }}" data-toggle="tooltip" data-placement="top" title="{{ $type->name }}">
                                      {{ $type->code }}
                                  </button>
                              @endforeach
                          </td>
                          <td>
                              <a href="{{ route('shelter.show', [$shelter->id]) }}" class="btn btn-xs btn-info" href="#" role="button">Pregled</a>
                              
                              @can('edit')
                                <a class="btn btn-xs btn-warning" href="{{ route("shelter.edit", $shelter) }}" role="button">Uredi</a>
                              @endcan
                          </td>
                      </tr>        
                  @endforeach
              </table>
              </div>
          </div>
      </div>
  </div>
</div> <!-- row -->


@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
@endpush