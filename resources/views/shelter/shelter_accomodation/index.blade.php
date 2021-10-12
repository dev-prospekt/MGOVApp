@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row inbox-wrapper">    
  <div class="col-lg-12"> 
    <div class="card">    
      <div class="card-body">
        <div class="title d-flex align-items-center justify-content-between">
        <h6 class="card-title">Osigurane opremljene nastambe</h6>
        <div>
          <a id="addAccomodation" href="javascript:void(0)" type="button" class="create btn btn-warning btn-icon-text">
              Dodaj nastambu
            <i class="btn-icon-append" data-feather="user-plus"></i>
          </a>
        </div>
      </div>  
          <!-- start card -->
          <div class="card mt-4">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 email-content">          
                  <div class="email-head">
                    <div class="email-head-subject">
                      <div class="title d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                          <a class="active" href="#"><span class="icon"><i data-feather="codepen" class="text-primary-muted"></i></span></a> 
                          <span>Letnica</span>
                        </div>
                        <div class="icons">
                          <a href="#" class="icon"><i data-feather="share" class="text-muted hover-primary-muted" data-toggle="tooltip" title="Forward"></i></a>
                          <a href="#" class="icon"><i data-feather="printer" class="text-muted" data-toggle="tooltip" title="Print"></i></a>
                          <a href="#" class="icon"><i data-feather="trash" class="text-muted" data-toggle="tooltip" title="Delete"></i>
                          </a>
                        </div>
                      </div>
                    </div>       
                  </div>
                  <div class="email-body">
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                    <br>
                    <p>Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna.</p>
                  </div>        
                </div>
                <div class="col-lg-4">         
                  <h6 class="card-title">Popratna fotodokumentacija</h6>
                  <div class="latest-photos">
                    <div class="row">
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      
                    </div>
                  </div>              
                </div>
              </div>
            </div>    
          </div>
          <!-- end card -->
          <div class="card mt-4">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-8 email-content">        
                  <div class="email-head">
                    <div class="email-head-subject">
                      <div class="title d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                          <a class="active" href="#"><span class="icon"><i data-feather="codepen" class="text-primary-muted"></i></span></a> 
                          <span>Letnica</span>
                        </div>
                        <div class="text-warning">Dimenzije: 10m x 15m x 7m</div>             
                      </div>
                    </div>  
                  </div>
                  <div class="email-body">
                    Opis:
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                    <br>
                    <p>Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna.</p>
                  </div>          
                </div>
                <div class="col-lg-4">         
                  <h6 class="card-title">Popratna fotodokumentacija</h6>
                  <div class="latest-photos">
                    <div class="row">
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>
                      <div class="col-md-4">
                        <figure>
                          <img class="img-fluid" src="{{ url('https://via.placeholder.com/100x100') }}" alt="">
                        </figure>
                      </div>                    
                    </div>
                  </div>              
                </div>
              </div>
            </div>      
          </div>
        </div>
      </div>
  </div>
</div>

<!-- Accomodation Modal -->
<div class="modal"></div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/dropzone.js') }}"></script>
<script>
  //Create
  $(".create").on('click', function(e){
                e.preventDefault();
               
                $.ajax({
                    url: "{{ route('shelter_accomodation.create') }}",
                    method: 'GET',
                    success: function(result) {
                      
                        $(".modal").show();
                        $(".modal").html(result['html']);
                        $('.modal').find("#shelterAccomodation").on('submit', function(e){
                            e.preventDefault();
                            var formData = this;
                            
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: "{{ route('user.store') }}",
                                method: 'POST',
                                data: new FormData(formData),
                                processData: false,
                                dataType: 'json',
                                contentType: false,
                                success: function(result) {
                                    if(result.errors) {
                                        $('.alert-danger').html('');
                                        $.each(result.errors, function(key, value) {
                                            $('.alert-danger').show();
                                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                        });
                                    } 
                                    else {
                                        $('.alert-danger').hide();
                                        $('.alert-success').show();
                                        setInterval(function(){
                                            $('.alert-success').hide();
                                            $('.modal').modal('hide');
                                            location.reload();
                                        }, 2000);
                                    }
                                }
                            });
                        });
                    }
                });

                // Modal
            $(".modal").on('click', '.modal-close', function(){
                $(".modal").hide();
            });
            });


</script>
@endpush