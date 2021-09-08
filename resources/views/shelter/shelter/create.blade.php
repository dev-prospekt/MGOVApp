@extends('layout.master')

@section('content')

<form action="{{ route("shelter.store") }}" method="POST">
    @csrf
    @method('POST')
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Naziv</label>
                <input type="text" class="form-control" name="name">
                @error('name')
                    <div class="text-danger">{{$errors->first('name') }} </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Šifra oporavilišta</label>
                <input type="text" class="form-control" name="shelterCode">
                @error('shelterCode')
                    <div class="text-danger">{{$errors->first('shelterCode') }} </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email">
                @error('email')
                    <div class="text-danger">{{$errors->first('email') }} </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Mjesto i poštanski broj</label>
                <input type="text" class="form-control" name="place_zip">
                @error('place_zip')
                    <div class="text-danger">{{$errors->first('place_zip') }} </div>
                @enderror
            </div>
            <div class="form-group">
                <label>Tel:</label>
                <input type="number" class="form-control" name="telephone">
            </div>
            <div class="form-group">
                <label>Fax</label>
                <input type="number" class="form-control" name="fax">
            </div>

            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>IBAN</label>
                <input type="number" class="form-control" name="iban">
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address">
                @error('address')
                    <div class="text-danger">{{$errors->first('address') }} </div>
                @enderror
            </div>
            <div class="form-group">
                <label>OIB</label>
                <input type="number" class="form-control" name="oib">
            </div>
            <div class="form-group">
                <label>Naziv banke</label>
                <input type="text" class="form-control" name="bank_name">
            </div>
            <div class="form-group">
                <label>Mob:</label>
                <input type="number" class="form-control" name="mobile">
            </div>
            <div class="form-group">
                <label>Web adresa</label>
                <input type="text" class="form-control" name="web_address">
            </div>
        </div>

    </div>
</form>

@endsection