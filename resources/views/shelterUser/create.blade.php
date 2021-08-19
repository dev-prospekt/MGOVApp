@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label>Korisničko ime</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="form-group">
                    <label>Ime i prezime</label>
                    <input type="text" class="form-control" name="name_lastname" required>
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
                    <label>Oporavilište kojem pripada</label>
                    <select name="shelter_id" required>
                        <option value="">Odaberi</option>
                        @foreach ($shelters as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
            </form>
        </div>
    </div>

@endsection