@extends('layout.master')

@section('content')

<form action="{{ route("user.store") }}" method="POST">
    @csrf
    @method('POST')
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Naziv</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label>Lozinka</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label>Oporavilište</label>
                <select class="form-control" name="shelter_id" id="">
                    @foreach ($shelters as $shelter)
                        <option value="{{ $shelter->id }}">{{ $shelter->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
        </div>
    </div>
</form>

@endsection