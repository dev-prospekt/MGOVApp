@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<form action="{{ route('animal.store') }}" method="POST">
    @csrf
    @method('POST')

    <div class="row">
        <div class="col-md-4">
            @if ($szj)
                <div class="form-group">
                    <label>Strogo Zaštićene</label>
                    <select name="animal_id" class="form-control">
                        <option value="">------</option>
                        @foreach ($szj as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>
        <div class="col-md-4">
            @if ($ij)
                <div class="form-group">
                    <label>Invazivne jedinke</label>
                    <select name="animal_id" class="form-control">
                        <option value="">------</option>
                        @foreach ($ij as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="col-md-4">
            @if ($zj)
                <div class="form-group">
                    <label>Zaplijenjene jedinke</label>
                    <select name="animal_id" class="form-control">
                        <option value="">------</option>
                        @foreach ($zj as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

    </div>

    <div class="row mt-3">
        <div class="col-md-4">
            <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
            <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">

            <div class="form-group">
                <label>Količina</label>
                <input type="number" class="form-control" name="quantity">
                @error('quantity')
                    <div class="text-danger">{{$errors->first('quantity') }} </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Datum pronalska</label>
                <div class="input-group date datepicker" id="datePickerExample">
                    <input type="text" name="date_found" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
        </div>
    </div>
</form>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
@endpush