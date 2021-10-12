@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <div>
            <a href="/shelter/{{ auth()->user()->shelter->id }}" class="btn btn-primary">
                <i data-feather="left" data-toggle="tooltip" title="Connect"></i>
                Natrag
            </a>
        </div>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <form action="{{ route('animal.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
        
            <div class="row">

                    @if (!empty($typeArray['SZJ']))
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6 class="text-muted">Strogo zaštićene</h6>
                                    </div>

                                    <div class="form-group">
                                        <select name="animal_id[]" class="form-control">
                                            <option value="">------</option>
                                            @foreach ($typeArray['SZJ'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            
                    @if (!empty($typeArray['IJ']))
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6 class="text-muted">Invazivne jedinke</h6>
                                    </div>

                                    <div class="form-group">
                                        <select name="animal_id[]" class="form-control">
                                            <option value="">------</option>
                                            @foreach ($typeArray['IJ'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            
                    @if (!empty($typeArray['ZJ']))
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h6 class="text-muted">Zaplijenjene jedinke</h6>
                                    </div>

                                    <div class="form-group">
                                        <select name="animal_id[]" class="form-control">
                                            <option value="">------</option>
                                            @foreach ($typeArray['ZJ'] as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
            </div>
        
            <div class="row mt-3">
                <div class="col-md-4">
                    <input type="hidden" name="shelter_id" value="{{ auth()->user()->shelter->id }}">
                    <input type="hidden" name="shelter_code" value="{{ auth()->user()->shelter->shelter_code }}">

                    <div class="form-group">
                        <label>Vrsta oznake</label>
                        <select name="oznaka" class="form-control">
                            <option value="">------</option>
                            <option value="otvoreni prsten">otvoreni prsten</option>
                            <option value="zatvoreni prsten">zatvoreni prsten</option>
                            <option value="mikročip">mikročip</option>
                            <option value="odašiljač">odašiljač</option>
                            <option value="krilna markica">krilna markica</option>
                            <option value="ušna markica">ušna markica</option>
                            <option value="neoznačena">neoznačena</option>
                            <option value="ostalo">ostalo</option>
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
                        <div class="input-group date datepicker" id="datePickerExample">
                            <input type="text" name="date_found" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Okolnosti i način pronalaska životinje</label>
                        <input type="text" class="form-control" name="okolnosti">
                    </div>

                    <div class="form-group">
                        <label>Lokacija na kojoj je životinja pronađena</label>
                        <input type="text" class="form-control" name="location">
                        @error('location')
                            <div class="text-danger">{{$errors->first('location') }} </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Dodatni opisni podaci oporavilišta o preuzimanju</label>
                        <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
                    </div>
        
                    <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
                </div>
        
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Dokumenti</label>
                        <input type="file" class="form-control border" name="documents[]" multiple>
                        @error('documents')
                            <div class="text-danger">{{$errors->first('documents') }} </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Stanje životinje u trenutku zaprimanja u oporavilište</label>
                        <select name="status_receiving" class="form-control">
                            <option value="">----</option>
                            <option value="iscrpljena/dehidrirana-bez vanjskih ozljeda">iscrpljena/dehidrirana-bez vanjskih ozljeda</option>
                            <option value="ozlijeđena/ranjena">ozlijeđena/ranjena</option>
                            <option value="otrovana">otrovana</option>
                            <option value="bolesna">bolesna</option>
                            <option value="uginula">uginula</option>
                            <option value="ostalo">ostalo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Upload stanja životinje u trenutku zaprimanja u oporavilište</label>
                        <input type="file" name="status_receiving_file[]" id="myDropify" class="border" multiple />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Stanje u kojem je životinja pronađena</label>
                        <select name="status_found" class="form-control">
                            <option value="">----</option>
                            <option value="iscrpljena/dehidrirana-bez vanjskih ozljeda">iscrpljena/dehidrirana-bez vanjskih ozljeda</option>
                            <option value="ozlijeđena/ranjena">ozlijeđena/ranjena</option>
                            <option value="otrovana">otrovana</option>
                            <option value="bolesna">bolesna</option>
                            <option value="uginula">uginula</option>
                            <option value="ostalo">ostalo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Upload stanja u kojem je životinja pronađena</label>
                        <input type="file" name="status_found_file[]" id="myDropify" class="border" multiple/>
                    </div>

                </div>
            </div>
        
        </form>
    </div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>

  <script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip(); 
    });
  </script>
@endpush