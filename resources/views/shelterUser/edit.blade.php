@extends('layout.master')

@section('content')

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>Korisničko ime</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                </div>
                <div class="form-group">
                    <label>Ime i prezime</label>
                    <input type="text" class="form-control" name="name_lastname" value="{{$user->name_lastname}}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" value="{{$user->email}}" required>
                </div>
                <div class="form-group">
                    <label>Oporavilište kojem pripada</label>
                    <select name="shelter_id" required>
                        <option value="{{$user->shelter_id}}">{{$user->shelter->name}}</option>
                        <option style="background: #757575;" value="">Za promjenu oporavilišta izaberite ispod</option>
                        @foreach ($shelters as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Ažuriraj</button>
            </form>
        </div>
    </div>

@endsection