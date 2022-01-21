@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="card grid-margin">
    <div class="card-body">

        <div class="row">
          <div class="col">
            <div class="mb-2"><h4>Dob jedinke</h4></div>
            <form action="" method="POST">
              @csrf
              @method('POST')

              <div class="form-group">
                <label>Naziv</label>
                <input type="text" name="name" class="form-control">
              </div>

              <div class="form-group">
                <input type="submit" class="btn btn-xs btn-sm btn-primary" value="Spremi">
              </div>
            </form>
          </div>
          <div class="col">
            <div class="mb-2"><h4>Stanje jedinke</h4></div>
            <form action="" method="POST">
              @csrf
              @method('POST')

              <div class="form-group">
                <label>Naziv</label>
                <input type="text" name="name" class="form-control">
              </div>

              <div class="form-group">
                <input type="submit" class="btn btn-xs btn-sm btn-primary" value="Spremi">
              </div>
            </form>
          </div>
          <div class="col">

          </div>
        </div>

    </div>
</div>

<div class="card grid-margin">
  <div class="card-body">

    <div class="row">
      <div class="col">
        <div class="mb-2"><h4>Popis dobi</h4></div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Naziv</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>Naziv</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col">
        <div class="mb-2"><h4>Popis stanja</h4></div>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Naziv</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>1</th>
                <td>Naziv</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col"></div>
    </div>

  </div>
</div>

@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
    $(function() {

    });
  </script>
@endpush
