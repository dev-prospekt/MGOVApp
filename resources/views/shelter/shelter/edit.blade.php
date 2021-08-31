@extends('layout.master')

@section('content')

<form action="{{ route("shelter.update", $shelter->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Naziv</label>
                <input type="text" class="form-control" name="name" value="{{ $shelter->name }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ $shelter->email }}" required>
            </div>
            <div class="form-group">
                <label>Mjesto i poštanski broj</label>
                <input type="text" class="form-control" name="place_zip" value="{{ $shelter->place_zip }}" required>
            </div>
            <div class="form-group">
                <label>Tel:</label>
                <input type="number" class="form-control" name="telephone" value="{{ $shelter->telephone }}" required>
            </div>
            <div class="form-group">
                <label>Fax</label>
                <input type="number" class="form-control" name="fax" value="{{ $shelter->fax }}" required>
            </div>
            <div class="form-group">
                <label>IBAN</label>
                <input type="number" class="form-control" name="iban" value="{{ $shelter->iban }}" required>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address" value="{{ $shelter->address }}" required>
            </div>
            <div class="form-group">
                <label>OIB</label>
                <input type="number" class="form-control" name="oib" value="{{ $shelter->oib }}" required>
            </div>
            <div class="form-group">
                <label>Naziv banke</label>
                <input type="text" class="form-control" name="bank_name" value="{{ $shelter->bank_name }}" required>
            </div>
            <div class="form-group">
                <label>Mob:</label>
                <input type="number" class="form-control" name="mobile" value="{{ $shelter->mobile }}" required>
            </div>
            <div class="form-group">
                <label>Web adresa</label>
                <input type="text" class="form-control" name="web_address" value="{{ $shelter->web_address }}" required>
            </div>
        </div>

    </div>
</form>

@endsection