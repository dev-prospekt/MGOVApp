@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="reports-tab" data-toggle="tab" href="#reports" role="tab" aria-controls="reports" aria-selected="true">
            Izvješća
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="table-reports-tab" data-toggle="tab" href="#table-reports" role="tab" aria-controls="table-reports" aria-selected="false">
            Tablica izvješća
        </a>
    </li>
</ul>

<div class="tab-content border border-top-0" id="myTabContent">
    <div class="tab-pane fade show active" id="reports" role="tabpanel" aria-labelledby="reports-tab">
        <div class="card">
            <div class="card-body">
                <div class="row mt-5">
                    <div class="col">
                        <div class="mb-3 text-center">
                            <h4>Export to excel</h4>
                        </div>
        
                        <form action="{{ route('export-to-excel') }}" method="POST">
                            @csrf
                            @method('POST')
        
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Jedinka</label>
                                        <select name="animal_category" class="js-example-basic-single w-100">
                                            <option value="">------</option>
                                            @foreach ($animalCategory as $animal_category)
                                                <option value="{{ $animal_category->id }}">{{ $animal_category->latin_name }}</option>
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
                                    <div class="form-group">
                                        <label>Razlog prestanka skrbi</label>
                                        <select name="care_end_type">
                                            <option value="">------</option>
                                            @foreach ($endCareType as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Oporavilišta</label>
                                        <select name="shelter" class="js-example-basic-single w-100">
                                            <option value="all">Sva oporavilišta</option>
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
                        <div class="mb-3 text-center">
                            <h4>ZNS-Zahtjev za nadoknadu sredstava</h4>
                        </div>
        
                        <form action="{{ route('reports-zns') }}" target="_blank" method="POST">
                            @csrf
                            @method('POST')
        
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Oporavilišta</label>
                                        <select name="shelter" class="js-example-basic-single w-100" required>
                                            <option value="">------</option>
                                            @foreach ($shelters as $shelter)
                                                <option value="{{ $shelter->id }}">{{ $shelter->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
        
                            <div class="row">
                                <div class="col">
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
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="table-reports" role="tabpanel" aria-labelledby="table-reports-tab">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        @if($msg = Session::get('reports-msg'))
                        <div id="successMessage" class="alert alert-success"> {{ $msg }}</div>
                        @endif

                        <div class="d-flex align-items-center justify-content-end">
                            <div class="grid-margin">
                                <a href="" type="button" class="reports-create btn btn-sm btn-primary btn-icon-text">
                                    Dodaj <i class="btn-icon-append" data-feather="activity"></i>
                                </a>
                            </div>
                        </div>
        
                        <div class="table-responsive-sm">
                            <table class="table" id="reports-table" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Naziv</th>
                                        <th>Datum</th>
                                        <th>Dokument</th>
                                        <th>Kreirao</th>
                                        <th>Status</th>
                                        <th>Akcije</th>
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
</div>

<div class="modal"></div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.hr.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/fileinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-fileinput/lang/cr.js') }}"></script>
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
                    orientation: "bottom",
                    language: 'hr'
                });
            }

            var reportTable = $('#reports-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('report-view') !!}',
                columns: [
                    { data: 'name', name: 'name'},
                    { data: 'date', name: 'date'},
                    { data: 'document', name: 'document'},
                    { data: 'author', name: 'author'},
                    { data: 'status', name: 'status'},
                    { data: 'action', name: 'action'},
                ],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.1/i18n/hr.json'
                },
                pageLength: 10,
            });

            // Status
            $('.table').on('click', '#reportStatus', function(e){
                e.preventDefault();

                var data = $(this).attr('data-id');
                var url = $(this).attr('data-url');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {'status': data},
                    success: function(result) {
                        if(result.status == 'ok'){
                            Swal.fire(
                                'Odlično!',
                                'Uspješno spremljeno!',
                                'success'
                            ).then((result) => {
                                reportTable.ajax.reload();
                            });
                        }
                    }
                }); 
            });

            //Create
            $(".reports-create").on('click', function(e){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('report-modal') }}",
                    method: 'GET',
                    success: function(result) {
                        $(".modal").show();
                        $(".modal").html(result['html']);
                        scriptsModal();

                        $('.modal').find("#reports-ajax").on('submit', function(e){
                            e.preventDefault();

                            var formData = this;

                            $.ajax({
                                url: "{{ route('report-save') }}",
                                method: 'POST',
                                data: new FormData(formData),
                                processData: false,
                                dataType: 'json',
                                contentType: false,
                                success: function(result) {
                                    console.log(result);
                                    if(result.status == 'ok'){
                                        $(".alert-success").show();
                                        $(".alert-success").html(result.message);
                                        
                                        setInterval(function(){
                                            location.reload();
                                        }, 1000);
                                    }
                                    else {
                                        $(".alert-danger").show();
                                        $.each(result.message, function(key, value) {
                                            $('.alert-danger').append('<p>'+value+'</p>');
                                        });
                                    }
                                }
                            });
                        });
                    }
                });
            });

            // Delete
            $('.table').on('click', '#deleteReports', function(){
                var url = $(this).attr('data-url');

                Swal.fire({
                    title: 'Jeste li sigurni?',
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
                                if(result.status == 'ok'){
                                    Swal.fire(
                                        'Odlično!',
                                        'Uspješno obrisano!',
                                        'success'
                                    ).then((result) => {
                                        reportTable.ajax.reload();
                                    });
                                }
                            }
                        }); 
                    }
                });
            });

            // Close Modal
            $(".modal").on('click', '.modal-close', function(){
                $(".modal").hide();
            });

            function scriptsModal()
            {
                if($('div#datePickerExample').length) {
                    $('div#datePickerExample').datepicker({
                        format: "mm/dd/yyyy",
                        todayHighlight: true,
                        autoclose: true,
                        language: 'hr'
                    });
                }

                $("#report_file").fileinput({
                    language: "cr",
                    maxFileCount: 2,
                    showPreview: false,
                    showUpload: false,
                    maxFileSize: 1500,
                    msgSizeTooLarge: 'Slika "{name}" (<b>{size} KB</b>) je veća od maksimalne dopuštene veličine <b>{maxSize} KB</b>. Pokušajte ponovno!',
                    allowedFileExtensions: ['xlsx', 'pdf'],
                    elErrorContainer: '#error_report_file',
                    msgInvalidFileExtension: 'Nevažeći format "{name}". Podržani su: "{extensions}"',
                });
            }

        });
    </script>
@endpush