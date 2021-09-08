@extends('layout.master')

@section('content')

<form action="{{ route("animal_item.update", $animalItem->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Veličina</label>
                <input type="text" class="form-control" name="animal_size" value="{{ $animalItem->animal_size }}" required>
            </div>
            <div class="form-group">
                <label>Spol</label>
                <input type="text" class="form-control" name="animal_gender" value="{{ $animalItem->animal_gender }}" required>
            </div>
            <div class="form-group">
                <label>Lokacija</label>
                <input type="text" class="form-control" name="location" value="{{ $animalItem->location }}" required>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Ažuriraj</button>
        </div>

    </div>
</form>

@endsection