@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-4 col-xl-4 mx-auto">
      <div class="card">
        <div class="row">
       
          <div class="col-md-12 pl-md-0">
            <div class="auth-form-wrapper px-4 py-5">
              <a href="#" class="noble-ui-logo logo-light d-block mb-2 font-weight-bold">
                Mgov<span>App</span>
              </a>
              <h5 class="text-muted font-weight-normal mb-4">Prijava u aplikaciju</h5>

              @if (!empty($errors->first()))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>    
                    <strong>{{ $errors->first('email') }}</strong>
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif

              <form class="forms-sample" method="POST" action="login" autocomplete="off">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Email adresa</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Lozinka</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="password"  placeholder="Password">
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0">Prijava</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection