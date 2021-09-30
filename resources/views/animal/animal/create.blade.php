@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<form action="{{ route('animal.store') }}" method="POST" multiple>
    @csrf
    @method('POST')

    <div class="row mt-3">
        <div class="col-md-4">
            <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
            <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">

            <div class="form-group">
                <label>Životinja</label>
                <select name="animal_id" class="form-control">
                    <option value="">------</option>
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                    @endforeach
                </select>
                @error('animal_id')
                    <div class="text-danger">{{$errors->first('animal_id') }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Code</label>
                <select class="js-example-basic-multiple w-100" name="animal_code_id[]" multiple="multiple">
                    @foreach ($animalsCode as $code)
                        <option value="{{ $code->id }}">{{ $code->name }}</option>
                    @endforeach
                </select>
                @error('animal_code_id')
                    <div class="text-danger">{{$errors->first('animal_code_id') }} </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Veličina</label>
                <select class="w-100" name="animal_size">
                    <option value="">Odaberi</option>
                    @foreach ($animalSize as $size)
                        <option value="{{ $size->value }}">{{ $size->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Količina</label>
                <input type="number" class="form-control" name="quantity">
                @error('quantity')
                    <div class="text-danger">{{$errors->first('quantity') }} </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Datum pronalska</label>
                <input type="date" class="form-control" name="date_found">
            </div>

            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
        </div>
    </div>
</form>
        
@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush