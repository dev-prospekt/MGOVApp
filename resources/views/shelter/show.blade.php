@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')

  <ul class="nav shelter-nav">
    <li class="nav-item">
      <a class="nav-link active" href="{{ route('shelter.show', $shelter->id) }}">Oporavilište</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelter.shelter_staff', $shelter->id) }}">Odgovorne osobe</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.accomodations.index', [$shelter->id]) }}">Smještajne jedinice</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.nutritions.index', [$shelter->id]) }}">Hranjenje životinja</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('shelters.equipments.index', [$shelter->id]) }}">Oprema, transport</a>
    </li>
  </ul>

    <div class="d-flex align-items-center justify-content-between mb-3">
      <div> <h5 class="mb-3 mb-md-0">{{ $shelter->name }}</h5></div>
    </div>

    <div>
      @if($msg = Session::get('update_shelter'))
        <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
      @endif
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Jedinke</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Podaci oporavilišta</a>
      </li>
    </ul>
    <div class="tab-content border border-top-0" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                  <div><h6 class="card-title">Popis vrsta</h6> </div>

                  <div class="grid-margin">
                    <a href="{{ route('shelterAnimal.create', [$shelter->id]) }}" type="button" class="btn btn-sm btn-primary btn-icon-text">
                      Dodaj jedinku
                      <i class="btn-icon-append" data-feather="activity"></i>
                    </a>
                  </div>
                </div>
                @if($msg = Session::get('msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif
        
                <div class="table-responsive-sm">
                  <table id="shelterAnimalTable" class="table">
                    <thead>          
                      <tr>
                        <th>#</th>
                        <th>Aktivne <br> jedinke</th>
                        <th>Kraj skrbi</th>
                        <th>Naziv</th>
                        <th>Latinski <br> naziv</th>
                        <th>Tip jedinke</th>
                        <th>Šifra</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>                
                  </table>
                </div>
        
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                  <div><h6 class="card-title">Podaci</h6> </div> 
                  <a href="{{ route('shelter.edit', $shelter->id) }}" class="btn btn-primary btn-sm btn-icon-text" type="button">
                    Izmjeni podatke
                    <i class="btn-icon-append" data-feather="box"></i>
                  </a>
                </div> 
                @if($msg = Session::get('update_shelter'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif      
                  <div class="row">
                    <div class="col-md-4 grid-margin">    
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv: </label>
                          <p class="text-muted">{{ $shelter->name ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa sjedišta:</label>
                          <p class="text-muted">{{ $shelter->address ?? '' }}</p>
                        </div>
      
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mjesto i poštanski broj:</label>
                          <p class="text-muted">{{ $shelter->place_zip ?? '' }}</p>
                        </div>
      
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa lokacije:</label>
                          <p class="text-muted">{{ $shelter->address ?? '' }}</p>
                        </div>
                        <div class="mt-2">
                          <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
                          <p class="text-muted">{{ $shelter->oib ?? '' }}</p>
                        </div>           
                    </div> 
      
                    <div class="col-md-4 grid-margin">
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ $shelter->email ?? '' }}</p>
                      </div>
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon: </label>
                        <p class="text-muted">{{ $shelter->telephone ?? '' }}</p>
                      </div>
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Fax:</label>
                        <p class="text-muted">{{ $shelter->fax ?? '' }}</p>
                      </div>
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel:</label>
                        <p class="text-muted">{{ $shelter->mobile ?? '' }}</p>
                      </div>
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Web stranica:</label>
                        <p class="text-muted">{{ $shelter->web_address ?? '' }}</p>
                      </div>
                    </div> 
      
                    <div class="col-md-4 grid-margin">
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">Banka: </label>
                        <p class="text-muted">{{ $shelter->bank_name ?? '' }}</p>
                      </div>
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">IBAN</label>
                        <p class="text-muted">{{ $shelter->iban ?? '' }}</p>         
                      </div> 
                      <div class="mt-2">
                      <label class="tx-11 font-weight-bold mb-0 text-uppercase">OVLAŠTENJE: </label>
                        @foreach ($shelter->shelterTypes as $type)
                          <p class="text-muted">
                            {{ $type->name ?? '' }}
                          </p>
                        @endforeach
                      </div>
      
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">DATUM REGISTRACIJE: </label>
                        <p class="text-muted">{{ $shelter->register_date ?? '' }}</p>  
                      </div>
      
                      <div class="mt-2">
                        <label class="tx-11 font-weight-bold mb-0 text-uppercase">ŠIFRA OPORAVILIŠTA: </label>
                        <p class="text-muted">{{ $shelter->shelter_code ?? '' }}</p>  
                      </div>
                    </div>       
                </div>         
              </div>
            </div>
          </div>      
        </div>
      </div>

    </div>

   
  
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
$(function() {
  var table = $('#shelterAnimalTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('shelter.show', [$shelter->id]) !!}',
      columns: [
          { data: 'id', name: 'id'},
          { data: 'animal_count_active', name: 'animal_count_active'},
          { data: 'animal_count_inactive', name: 'animal_count_inactive'},
          { data: 'name', name: 'name'},
          { data: 'latin_name', name: 'latin_name'},
          { data: 'animal_type', name: 'animal_type'},
          { data: 'shelter_code', name: 'shelter_code'},
          { data: 'action', name: 'action'},
      ],
      order: [[ 0, "desc" ]],
      language: {
          url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
      }
  });

  // Delete AnimalGroup
  $('#shelterAnimalTable').on('click', '#animal_group_delete', function(){
    var url = $(this).attr('data-href');

    console.log(url);

    Swal.fire({
        title: 'Jeste li sigurni?',
        text: "Obrisat će se grupa ali možete je i dalje vidjeti!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Da, obriši!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function(result) {
                  if(result.msg == 'success'){
                      Swal.fire(
                          'Odlično!',
                          'Uspješno obrisano!',
                          'success'
                      ).then((result) => {
                          table.ajax.reload();
                      });
                  }
                }
            }); 
        }
    });
  });
});
</script>
@endpush