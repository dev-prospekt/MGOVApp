@extends('layout.master')

@section('content')
<div class="profile-page tx-13">

  <div class="row profile-body">

    <div class="d-md-block col-md-5">
      <div class="card rounded">
        <div class="card-body p-5">

          <div class="d-flex align-items-center justify-content-between mb-2 mt-3">
            <h6 class="card-title mb-0">PROMIJENI LOZINKU</h6>
          </div>

          @if($msg = Session::get('msg_pass'))
          <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
          @endif

          <hr>
          
          <form action="{{ route('password.update') }}" method="POST">
              @csrf

              <input type="hidden" name="user_id" value="{{ $user->id }}">

              <div class="mt-3">
                <div class="form-group">
                  <input type="hidden" id="email_address" class="form-control" name="email" value="{{ $user->email }}" required />
                </div>
              </div>

              <div class="mt-3">
                <div class="form-group">
                    <label class="font-weight-bold mb-0 text-uppercase">Nova lozinka:</label>
                    <input type="password" id="password" class="form-control" name="password" autofocus required />
                </div>
              </div>

              <div class="mt-3">
                <div class="form-group">
                    <label class="font-weight-bold mb-0 text-uppercase">Potvrda lozinke:</label>
                    <input type="password" id="password-confirm" class="form-control" name="password_confirmation" autofocus required />
                </div>
              </div>

              <div>
                <button type="submit" class="btn btn-primary">
                  Spremi
                </button>
              </div>
          </form>

        </div>
      </div>
    </div>
    
  </div>
</div>
@endsection