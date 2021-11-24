@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="d-flex align-items-center justify-content-between">
    <div> <h5 class="mb-3 mb-md-0">{{ $animalItem->first()->shelter->name }}</h5></div>
    <div>      
      <a href="{{ $animalItem->first()->shelter->id }}" type="button" class="btn btn-primary btn-icon-text">
          Povratak na popis
          <i class="btn-icon-append" data-feather="clipboard"></i>
        </a>                      
    </div>
  </div>

<div class="row mt-4">
    <div class="col-md-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">Podaci o zaprimanju</h6>

                @if($msg = Session::get('msg'))
                <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                @endif

                <div class="table-responsive">
                <table class="table" id="animal-table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Naziv vrste</th>
                        <th>Latinski naziv</th>
                        <th>SPOL</th>
                        <th>VELIČINA</th>
                        <th>Dob jedinke</th>
                        <th>Solitarno/grupa</th>                             
                    </tr>
                    </thead>
                    <tbody>
                            @foreach ($animalItem as $anim)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $anim->animal->name  }}</td>
                                    <td>{{ $anim->animal->latin_name  }}</td>
                                    <td>{{ $anim->animal_gender }}</td>
                                    <td>{{ $anim->animal->animalSize->sizeAttributes->first()->name }}</td>
                                    <td>{{ $anim->animal_dob }}</td>
                                    <td>{{ $anim->animal_keep_type }}</td>
                                
                                    
                                    <td>
                                        <a href="{{ route('animal_item.show', $anim) }}" class="btn btn-warning btn-sm">
                                            Pregled
                                        </a>
                                        <a href="{{ route('animal_item.edit', $anim) }}" class="btn btn-info btn-sm">
                                            Uredi
                                        </a>
                                        <button type="button" class="btn btn-primary premjesti btn-sm" data-id="{{$anim->id}}">
                                            Premjesti
                                        </button>
                                       
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
                </div>
            </div>
        </div>
            
    </div>
</div> <!-- row -->

<div class="row">
    <div class="col-md-8 grid-margin">
        <div class="card">
            <div class="card-body">
              <div class="row inbox-wrapper">
            
                <div class="col-lg-12 email-content">
                  <div class="email-inbox-header">
                    <div class="row justify-content-between">           
                        <div class="email-title mb-2 mb-md-0"><span class="icon"><i data-feather="book"></i></span> Postupak postupanja u oporavilištu</div>  
                        <div>
                        <a type="button" class="btn btn-primary btn-sm btn-icon-text" data-toggle="modal" 
                            data-target="#createCareStaffModal">
                              
                              
                              Dodaj zapis
                              <i class="btn-icon-append" data-feather="book"></i>
                            </a> 
                        </div>
                     
                    </div>
                  </div>
                  <div class="separator--small"></div>
             
                  <div class="email-list">      
                    <div class="email-list-item">
               
                      <a href="{{ url('/email/read') }}" class="email-list-detail">
                        <div>
                          <span class="from">Primjer naziva za dnevnik unosa u oporavilište</span>
                          <p class="msg">Predmet vezan za dnevnik unosa </p>
                        </div>
                        <div class="justify-content-between"> 
                        <span class="date">
                          
                          23.11. 2021.
                        </span>
                        <a class="btn btn-warning btn-xs mt-1">
                            pregled
                         </a> 
                        </div>
                      </a>
                    </div>
                    <div class="email-list-item">
              
                      <a href="{{ url('/email/read') }}" class="email-list-detail">
                        <div>
                          <span class="from">Primjer naziva za dnevnik unosa u oporavilište</span>
                          <p class="msg">Predmet vezan za dnevnik unosa </p>
                        </div>
                        <div class="justify-content-between"> 
                            <span class="date">
                           
                              23.11. 2021.
                            </span>
                            <a class="btn btn-warning btn-xs mt-1">
                                pregled
                             </a> 
                        </div>
                      </a>
                    </div>
                    <div class="email-list-item">
                
                      <a href="{{ url('/email/read') }}" class="email-list-detail">
                        <div>
                          <span class="from">Primjer naziva za dnevnik unosa u oporavilište</span>
                          <p class="msg">Predmet vezan za dnevnik unosa </p>
                        </div>
                        <div class="justify-content-between"> 
                            <span class="date">
                              23.11. 2021.
                            </span>
                            <a class="btn btn-warning btn-xs mt-1">
                                pregled
                             </a> 
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        
    </div>

    <div class="col-md-4 grid-margin">
        <div class="card rounded grid-margin">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="card-title mb-0">Dokumenti</h6>
                </div>

            </div>
        </div>

        <div class="card rounded grid-margin">
            <div class="card-body">
                <p>Stanje u trenutku zaprimanja u oporavilište</p>

                <div class="d-flex align-items-center flex-wrap">
               
                </div>

                <p>Stanje u kojem je zaplijena pronađena</p>            
                    <div class="d-flex align-items-center flex-wrap">
                    </div>
            </div>
        </div>
    </div>

</div> <!-- row -->


<!-- Modal -->
<button type="button" id="openModal" class="btn btn-primary d-none" data-toggle="modal" data-target="#exampleModalCenter">
</button>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <form id="changeShelterForm" action="" method="POST">
                    @csrf
                    @method('POST')
        
                    <div class="form-group">
                        <h6>Oporavilište u kojem se nalazi:</h6>
                        <span>{{ $animalItem->first()->shelter->name }}</span>
                    </div>
                    <input type="hidden" name="animal_id" id="animal_id">
                    <input type="hidden" name="shelter_code" id="shelterCode">

                    <select id="shelter_id" name="shelter_id">
                        <option value="">Odaberite oporavilište</option>
                        @foreach ($shelters as $shelter)
                            @if ($animalItem->first()->shelter->id != $shelter->id)
                                <option value="{{$shelter->id}}">{{$shelter->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="closeModal" class="btn btn-secondary" data-dismiss="modal">Odustani</button>
        <button type="button" id="save" class="btn btn-primary">Ažuriraj</button>
    </div>
    </div>
</div>
</div>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    

    <script>
        $(function() {
            // Premjestaj
            $(".premjesti").click(function(){
                $("#openModal").trigger('click');

                id = $(this).attr("data-id");

                $.get( "/animal_item/getId/" + id, function( data ) {
                    console.log(data)
                    $('#changeShelterForm').attr('action', '/animal_item/changeShelter/'+id);
                    $('#animal_id').val(data.animal_id);
                    $('#shelterCode').val(data.shelter_code);
                });
                
            });

            $("#save").click(function(){
                $("#changeShelterForm").submit();
            });
        })
    </script>

    <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush