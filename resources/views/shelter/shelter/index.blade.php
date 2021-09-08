@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="row">
    <div class="col-lg-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title">Oporavilišta za divlje životinje</h6>
                        <p class="card-description">Ministarstvo gospodarstva i održivog razvoja</p>
                    </div>
                    <div>
                        <a href="{{ route("shelter.create") }}" class="btn btn-primary">Dodaj</a>
                    </div>
                </div>

                <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NAZIV OPORAVILIŠTA</th>
                        <th>ADRESA OPORAVILIŠTA</th>
                        <th>EMAIL</th>
                        <th>TELEFON</th>
                        <th>ADMINISTRATOR</th>
                        <th>Ovlašteno</th>
                        <th>AKCIJA</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($shelters as $shelter)
                        <tr>
                            <td>{{ $shelter->id }}</td>
                            <td>{{ $shelter->name }}</td>                 
                            <td>{{ $shelter->address }}</td>
                            <td>{{ $shelter->email }}</td>
                            <td>{{ $shelter->telephone }}</td>
                            <td>{{ $shelter->users->first()->name ?? '' }}</td>
                            <td>
                                @foreach ($shelter->shelterTypes as $type)
                                    <button type="button" class="btn btn-{{ $type->id == 1 ? 'warning' : 'danger' }}" data-toggle="tooltip" data-placement="top" title="{{ $type->name }}">
                                        {{ $type->code }}
                                    </button>
                                @endforeach
                            </td>
                            <td class="d-flex justify-content-between">
                                <a href="{{ route('shelter.show', [$shelter->id]) }}" class="btn btn-info" href="#" role="button">Pregled</a>
                                <a class="btn btn-warning" href="{{ route("shelter.edit", $shelter) }}" role="button">Uredi</a>
                                <a href="javascript:void(0)" id="shelterClick" class="btn btn-danger">
                                    <input type="hidden" id="shelter_id" value="{{$shelter->id}}">
                                    Obriši
                                </a>
                            </td>
                        </tr>        
                    @endforeach
                </table>
                </div>
            </div>
        </div>
    </div>
</div> <!-- row -->

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script>
    $(function() {

        // Delete
        $('.table').on('click', '#shelterClick', function(){
            var id = $(this).find('#shelter_id').val();

            Swal.fire({
                title: 'Jeste li sigurni?',
                text: "Želite obrisati oporavilište i više neće biti dostupno!",
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
                        url: "shelter/"+id,
                        method: 'DELETE',
                        success: function(result) {
                            if(result.msg == 'success'){
                                Swal.fire(
                                    'Odlično!',
                                    'Uspješno obrisano!',
                                    'success'
                                ).then((result) => {
                                    location.reload(); 
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