@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
@endpush

@section('content')
<div class="row">
  <div class="col-md-6">
    <div class="card rounded grid-margin">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-2">
              <h6 class="card-title mb-0">Eutanazija</h6>
          </div>

          @if ($animalItem->animal->animalType->first()->type_code == 'IJ')

          @endif

          @if($msg = Session::get('euthanasiaMsg'))
            <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
            @endif

          <form action="{{ route('animal_items.euthanasia.store', [$animalItem]) }}" method="POST" enctype="multipart/form-data">
              @csrf

              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Veterinar</label>
                          <select class="form-control" name="staff" id="">
                              <option value="">Odaberi</option>
                              @foreach ($animalItem->shelter->shelterStaff as $staff)
                                  <option value="{{ $staff->id }}">{{ $staff->name }} ({{ $staff->shelterStaffType->name }})</option>
                              @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label>Cijena</label>
                          <input type="number" class="form-control" name="price">
                      </div>
                  </div>
                  
                  <div class="col-md-6">
                      <div class="form-group">
                          <label>Račun</label>
                          <input type="file" id="euthanasia_file" name="euthanasia_file" />
                          <div id="error_euthanasia_file"></div>
                      </div>
                  </div>
              </div>

              <div>
                  <button type="submit" class="btn btn-primary mr-2">Spremi</button>
              </div>
          </form>

      </div>
  </div>
  </div>
  <div class="col-md-6">
    <div class="card rounded grid-margin">
        <div class="card-body">
            <h6>Veterinar koji je napravio eutanaziju</h6>

            <div class="d-flex align-items-center flex-wrap mt-1 mb-3">
              <p>Ime: {{ $animalItem->euthanasia->shelterStaff->name ?? '' }} ({{ $animalItem->euthanasia->shelterStaff->shelterStaffType->name ?? '' }})</p>
            </div>

            <h6>Cijena i računi:</h6>            
            <div class="d-flex align-items-center flex-wrap mt-1 mb-3">
              <span>Cijena: {{ $animalItem->euthanasia->price ?? '' }}</span>
            </div>

            <div class="d-flex align-items-center flex-wrap">
              <p>Račun:</p>

              @if(!empty($animalItem->euthanasia))
                @foreach ($animalItem->euthanasia->getMedia('euthanasia_file') as $item)
                  <a target="_blank" href="{{ $item->getUrl() }}">{{ $item->name }}</a>
                @endforeach
              @endif
            </div>
        </div>
    </div>
  </div>
  
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/lightbox2/lightbox.min.js') }}"></script> 
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>

  <script>  
      $(function() {
        /*euthanasia js*/
          $("#euthanasia_file").fileinput({
              language: "cr",
              //required: true,
              showPreview: false,
              showUpload: false,
              showCancel: false,
              allowedFileExtensions: ["pdf"],
              elErrorContainer: '#error_euthanasia_file',
              msgInvalidFileExtension: 'Nevažeći dokument "{name}". Podržani su samo "{extensions}"',
          });
      })
  </script>

  <script src="{{ asset('assets/js/select2.js') }}"></script>