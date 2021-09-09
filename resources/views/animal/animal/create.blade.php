@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('animal.store') }}" method="POST" multiple>
                @csrf
                @method('POST')

                <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
                <input type="hidden" name="shelterCode" value="{{ auth()->user()->shelter->shelterCode }}">

                <div class="form-group">
                    <select name="animal_id" class="form-control">
                        @foreach ($animals as $animal)
                            <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                        @endforeach
                    </select>
                    @error('animal_id')
                        <div class="text-danger">{{$errors->first('animal_id') }} </div>
                    @enderror
                </div>

                <div class="form-group">
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
                    <input type="number" class="form-control" name="quantity">
                    @error('quantity')
                        <div class="text-danger">{{$errors->first('quantity') }} </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
            </form>
        </div>
    </div>

@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush