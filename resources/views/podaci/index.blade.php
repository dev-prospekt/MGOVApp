@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">

    <div class="col-lg-4 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div>
                    <div>
                        <h6 class="card-title">Spol</h6>
                    </div>
                    <div class="mb-4">
                        <select class="form-control form-control-sm">
                            @foreach ($animalDob as $item)
                                <option>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($msg = Session::get('animalDobMsg'))
                <div id="successMessage" class="alert alert-success" style="padding: 5px 20px;"> {{ $msg }}</div>
                @endif

                <form action="{{ route('podaci-animal-dob') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Naziv</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-xs btn-primary">Dodaj</button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-lg-4 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div>
                    <div>
                        <h6 class="card-title">Način držanja</h6>
                    </div>
                    <div class="mb-4">
                        <select class="form-control form-control-sm">
                            @foreach ($animalSolitaryGroup as $item)
                                <option>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($msg = Session::get('animal_solitary_or_group_msg'))
                <div id="successMessage" class="alert alert-success" style="padding: 5px 20px;"> {{ $msg }}</div>
                @endif

                <form action="{{ route('animal-solitary-group') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Naziv</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-xs btn-primary">Dodaj</button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-lg-4 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div>
                    <div>
                        <h6 class="card-title">Stanje jedinke</h6>
                    </div>
                    <div class="mb-4">
                        <select class="form-control form-control-sm">
                            @foreach ($animalStatus as $item)
                                <option>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($msg = Session::get('animal_status_msg'))
                <div id="successMessage" class="alert alert-success" style="padding: 5px 20px;"> {{ $msg }}</div>
                @endif

                <form action="{{ route('podaci-animal-status') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Naziv</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-xs btn-primary">Dodaj</button>
                </form>

            </div>
        </div>
    </div>

    <div class="col-lg-4 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div>
                    <div>
                        <h6 class="card-title">Lokacija preuzimanja životinje</h6>
                    </div>
                    <div class="mb-4">
                        <select class="form-control form-control-sm">
                            @foreach ($animalLocationTakeover as $item)
                                <option>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($msg = Session::get('location_animal_takeover_msg'))
                <div id="successMessage" class="alert alert-success" style="padding: 5px 20px;"> {{ $msg }}</div>
                @endif

                <form action="{{ route('podaci-location-animal-takeover') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Naziv</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-xs btn-primary">Dodaj</button>
                </form>

            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">

    <div class="col-lg-4 col-xl-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div>
                    <div>
                        <h6 class="card-title">Razlog prestanka skrbi</h6>
                    </div>
                    <div class="mb-4">
                        <select class="form-control form-control-sm">
                            @foreach ($animalItemCareEndType as $item)
                                <option>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($msg = Session::get('animal_care_end_status_msg'))
                <div id="successMessage" class="alert alert-success" style="padding: 5px 20px;"> {{ $msg }}</div>
                @endif

                <form action="{{ route('animal-care-end-status') }}" method="POST">
                    @csrf
                    @method('POST')
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Naziv</label>
                                <input type="text" name="name" class="form-control" required />
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-xs btn-primary">Dodaj</button>
                </form>

            </div>
        </div>
    </div>

</div>

@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
    $(function() {

        
    });
  </script>
@endpush
