@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('animal.store') }}" method="POST">
                @csrf
                @method('POST')

                <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">

                <div class="form-group">
                    <select name="animal_id" class="form-control">
                        @foreach ($animals as $animal)
                            <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <input type="number" class="form-control" name="quantity">
                </div>

                <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
            </form>
        </div>
    </div>

@endsection