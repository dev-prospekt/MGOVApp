@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')


<div class="d-flex align-items-center justify-content-between">
  <nav class="page-breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="#">{{ $shelter->name ?? '' }}</a></li>
      <li class="breadcrumb-item active" aria-current="page">Aktivno</li>
    </ol>
  </nav>
  <div>
       
      <a href="javascript:void(0)" class="btn btn-primary btn-icon-text create_staff_modal" data-toggle="modal" 
      data-target="#createStaffModal" type="button" class="btn btn-primary btn-icon-text">
        Odgovorna osoba - pravna osoba
        <i class="btn-icon-append" data-feather="user-plus"></i>
      </a>

      <a type="button" class="btn btn-warning btn-icon-text">
        Odgovorna osoba - skrb životinja
        <i class="btn-icon-append" data-feather="user-plus"></i>
      </a>

      <a type="button" class="btn btn-info btn-icon-text">
        Pružatelj veterinarske usluge
        <i class="btn-icon-append" data-feather="plus-circle"></i>
      </a>
              
  </div>
</div>

<div class="row mt-4">
    <div class="col-md-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">{{ $shelter->name ?? '' }}</h6>
          <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>          
            <div class="row">
              <div class="col-md-4 grid-margin">    
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Naziv: </label>
                    <p class="text-muted">{{ $shelter->name ?? '' }}</p>
                  </div>
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa sjedišta:</label>
                    <p class="text-muted">{{ $shelter->address ?? '' }}</p>
                  </div>

                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mjesto i poštanski broj:</label>
                    <p class="text-muted">{{ $shelter->place_zip ?? '' }}</p>
                  </div>

                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa lokacije:</label>
                    <p class="text-muted">{{ $shelter->address ?? '' }}</p>
                  </div>
                  <div class="mt-3">
                    <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
                    <p class="text-muted">{{ $shelter->oib ?? '' }}</p>
                  </div>           
              </div> 

              <div class="col-md-4 grid-margin">
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                  <p class="text-muted">{{ $shelter->email ?? '' }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon: </label>
                  <p class="text-muted">{{ $shelter->telephone ?? '' }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Fax:</label>
                  <p class="text-muted">{{ $shelter->fax ?? '' }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel:</label>
                  <p class="text-muted">{{ $shelter->mobile ?? '' }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Web stranica:</label>
                  <p class="text-muted">{{ $shelter->web_address ?? '' }}</p>
                </div>
              </div> 

              <div class="col-md-4 grid-margin">
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">Banka: </label>
                  <p class="text-muted">{{ $shelter->bank_name ?? '' }}</p>
                </div>
                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">IBAN</label>
                  <p class="text-muted">{{ $shelter->iban ?? '' }}</p>         
                </div> 
                <div class="mt-3">
                <label class="tx-11 font-weight-bold mb-0 text-uppercase">OVLAŠTENJE: </label>
                  <p class="text-muted">
                    @foreach ($shelter->shelterTypes as $type)
                    {{ $type->name ?? '' }}
                    @endforeach
                  </p>
                </div>

                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">DATUM REGISTRACIJE: </label>
                  <p class="text-muted">{{ $shelter->register_date ?? '' }}</p>  
                </div>

                <div class="mt-3">
                  <label class="tx-11 font-weight-bold mb-0 text-uppercase">ŠIFRA OPORAVILIŠTA: </label>
                  <p class="text-muted">{{ $shelter->shelter_code ?? '' }}</p>  
                </div>
              </div>       
          </div>         
        </div>
      </div>
    </div>
    
</div>
<div class="row">
  <div class="col-md-8 grid-margin">
  <div class="card">
    <div class="card-body ">
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <h6 class="card-title">Pravno Odgovorna osoba</h6>        
        </div>
        <div>
          <button type="button" class="btn btn-primary btn-icon"  data-id="{{ $shelterLegalStaff->id ?? ''  }}"  data-toggle="modal" data-target="#editStaffLegalModal">
            <i data-feather="check-square"></i>
          </button>
               
            <button type="button" id="deleteLegalStaff" type="button" class="btn btn-danger btn-icon" 
            data-id="{{ $shelterLegalStaff->id ?? ''  }}">
              <i data-feather="box"></i>
            </button>
    
        </div>
      </div> 
      <div class="row">
     
        <div class="col-md-4 grid-margin">  
         
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Ime i prezime: </label>
            <p class="text-muted">{{ $shelterLegalStaff->name ?? '' }}</p>
          </div>
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">OIB:</label>
            <p class="text-muted">{{ $shelterLegalStaff->oib ?? '' }}</p>
          </div>

           
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa prebivališta:</label>
            <p class="text-muted">{{ $shelterLegalStaff->address ?? '' }}</p>
          </div>                     
        </div> 

        <div class="col-md-4 grid-margin">
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Adresa Boravišta</label>
            <p class="text-muted">{{ $shelterLegalStaff->address_place ?? '' }}</p>
          </div> 
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Telefon:</label>
            <p class="text-muted">{{ $shelterLegalStaff->phone ?? '' }}</p>
          </div>
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Mobitel: </label>
            <p class="text-muted">{{ $shelterLegalStaff->phone_cell ?? '' }}</p>
          </div>
              
        </div> 
        <div class="col-md-4 grid-margin">
          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
            <p class="text-muted">{{ $shelterLegalStaff->email ?? '' }}</p>
          </div>

          <div class="mt-3">
            <label class="tx-11 font-weight-bold mb-0 text-uppercase">Uvjerenje protiv kaznenog postupka:</label>        
              <div class="d-md-block mt-2">
                  @if ($file)
                  <i data-feather="paperclip" class="text-muted"></i> <a href="{{ $file->getUrl() }}"> {{ $file->file_name }}  </a>
                  @endif     
              </div>
          </div>
        </div>       
      </div>       
    </div>
  </div> 
</div>

<div class="col-md-4  grid-margin">
  <div class="card rounded">
    <div class="card-body">
      <h6 class="card-title">Korisnici Oporavilišta</h6>        
      @foreach ($shelter->users as $user)   
        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
          <div class="d-flex align-items-center hover-pointer">
            <img class="img-xs rounded-circle" src="{{ url('https://via.placeholder.com/37x37') }}" alt="">													
            <div class="ml-2">
              <p>{{ $user->name }} | {{ $user->email ?? ''}}</p>
              <p class="tx-11 text-muted">{{ $user->roles()->first()->name ?? ''}}</p>
            </div>
          </div>
          <button class="btn btn-icon"><i data-feather="user-plus" data-toggle="tooltip" title="Connect"></i></button>
        </div>
      @endforeach              
    </div>
  </div> 
</div>
</div> 

{{-- Create Legal Staff Modal --}}
@include('shelter.shelter.shelter_staff_legal._create')

{{-- Update Legal Staff Modal --}}
@include('shelter.shelter.shelter_staff_legal._update')


@endsection


@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/file-upload.js') }}"></script>

<script>

      $(function() {
           
                  // Create Legal Shelter Staff Ajax request.
                   $('#createLegalStaff').on('submit', function(e) {
                      e.preventDefault();

                      var form = this;
                    
                      $.ajax({
                          url: $(form).attr('action'),
                          method: 'POST',
                          data: new FormData(form),
                          processData: false,
                          dataType: 'json',
                          contentType: false,

                          success: function(result) {
                            console.log(result);
                            
                              if(result.errors) {
                                  $('.alert-danger').html('');
                                  console.log(result);
                                  $.each(result.errors, function(key, value) {
                                      $('.alert-danger').show();
                                      $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                  });
                              } else {
                                  $('.alert-danger').hide();
                                  $('.alert-success').show();
                  
                                  setInterval(function(){ 
                                      $('.alert-success').hide();
                                      $('#createStaffLegalModal').modal('hide');
                                      location.reload();
                                  }, 2000);
                              }
                          }
                      });
                });
        
                // Update Legal Shelter Staff Ajax request.
                $('#updateLegalStaff').on('submit', function(e) {
                    e.preventDefault();
                    var updateForm = this;
                  
                    $.ajax({
                        url: $(updateForm).attr('action'),
                        method: 'POST',
                        data: new FormData(updateForm),
                        processData: false,
                        dataType: 'json',
                        contentType: false,

                        success: function(result) {
                        console.log(result);
                          
                            if(result.errors) {
                                $('.alert-danger').html('');
                                console.log(result);
                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                });
                            } else {
                            
                                $('.alert-danger').hide();
                                $('.alert-success').show();
                
                                setInterval(function(){ 
                                    $('.alert-success').hide();
                                    $('#editStaffLegalModal').modal('hide');
                                    location.reload();
                                    console.log(result);
                                }, 2000);
                            }
                        }
                    });
                });

                $('body').on('click', '#deleteLegalStaff', function() {

                  deleteID = $(this).data('id');
                  
                  Swal.fire({
                      title: "Brisanje?",
                      text: "Potvrdite ako ste sigurni za brisanje Osobe!",
                      type: "warning",
                      showCancelButton: !0,
                      confirmButtonText: "Da, brisanje!",
                      cancelButtonText: "Ne, odustani!",
                      reverseButtons: !0
                  }).then(function (e) {

                if (e.value === true) {
                    
                    console.log('brisi');
                    
                    $.ajaxSetup({
                      headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                
                  });
                    $.ajax({
                        type: 'DELETE',
                        url: "{{url('/shelter_legal_staff')}}/" + deleteID,
                        data: {_token: '{{csrf_token()}}'},
                        dataType: 'JSON',
                        success: function (results) {
                            location.reload();
                        }
                    });

                } else {
                    e.dismiss;
                }

            }, function (dismiss) {
                return false;
            })
          });
       

        })
     
  </script>
 
@endpush