@extends('layout.master')

@section('content')
<form action="{{ route("user.update", $user->id) }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>Naziv</label>
                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label>Oporavilište</label>
                <select class="form-control" name="shelter_id" id="">
                    <option value="{{ $user->shelter->id }}">{{ $user->shelter->name }}</option>
                    <option value="">-------------</option>
                    @foreach ($shelters as $shelter)
                        <option value="{{ $shelter->id }}">{{ $shelter->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Ažuriraj</button>
        </div>
    </div>
</form>

@endsection