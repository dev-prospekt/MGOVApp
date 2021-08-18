@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Oporavilišta</a></li>
    <li class="breadcrumb-item active" aria-current="page">Aktivno</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Oporavilišta za divlje životinje</h6>
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
                  <th>ŽIVOTINJE</th>
                  <th>AKCIJA</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($shelters as $shelter)
                <tr>
                  <td>{{ $shelter->id }}</td>
                  <td>{{ $shelter->name  }}</td>
                  <td>{{ $shelter->address }}</td>
                  <td>{{ $shelter->oib }}</td>
                  <td>{{ auth()->user()->email }}</td>
                  <td><a href="{{ route('shelter.show', $shelter) }}" class="btn btn-primary btn-icon-text">
                    <i class="btn-icon-prepend" data-feather="check-square"></i>Informacije</a></td>
                  <td><a class="btn btn-primary btn-icon" href="#" role="button"><i data-feather="check-square"></i></a>
                    <a class="btn btn-danger btn-icon" href="#" role="button">  <i data-feather="box"></i></a></td>
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