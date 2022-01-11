@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col text-center">
                <h2>Izvješća</h2>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col">
                <div class="mb-3">
                    <h5>Export to excel</h5>
                </div>

                <form action="{{ route('export-to-excel') }}" method="POST">
                    @csrf
                    @method('POST')

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Jedinka</label>
                                <select name="animal" class="js-example-basic-single w-100">
                                    <option value="">------</option>
                                    @foreach ($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Od</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="start_date" class="form-control">
                                    <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Oporavilišta</label>
                                <select name="shelter" class="js-example-basic-single w-100">
                                    <option value="">------</option>
                                    @foreach ($shelters as $shelter)
                                        <option value="{{ $shelter->id }}">{{ $shelter->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Do</label>
                                <div class="input-group date datepicker" id="datePickerExample">
                                    <input type="text" name="end_date" class="form-control">
                                    <span class="input-group-addon">
                                    <i data-feather="calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Spremi</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col">

            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script>
        $(function() {

            if ($(".js-example-basic-single").length) {
                $(".js-example-basic-single").select2();
            }

            if($('div#datePickerExample').length) {
                $('div#datePickerExample').datepicker({
                    format: "mm/dd/yyyy",
                    todayHighlight: true,
                    autoclose: true,
                });
            }

        });
    </script>
@endpush