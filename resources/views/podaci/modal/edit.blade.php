
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ route('podaci-update', [$data->id]) }}" method="POST">
                @csrf
                @method('POST')
                
                <input type="hidden" name="data_id" value="{{ $data->id }}">
                <input type="hidden" name="model" value="{{ $model }}">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" name="name" class="form-control" value="{{ $data->name }}" required />
                        </div>
                    </div>
                </div>

                {{-- Vrsta oznake --}}
                @if($model == 'Vrsta oznake')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Opis</label>
                            <input type="text" name="desc" class="form-control" value="{{ $data->desc }}" required />
                        </div>
                    </div>
                </div>
                @endif

                {{-- Kvartal --}}
                @if($model == 'Kvartal')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Datum od</label>
                            <input type="text" name="date_from" class="form-control" value="{{ $data->from }}" required />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Datum do</label>
                            <input type="text" name="date_to" class="form-control" value="{{ $data->to }}" required />
                        </div>
                    </div>
                </div>
                @endif

                {{-- Tip smještajne jedinice --}}
                @if($model == 'Tip smještajne jedinice' || $model == 'Tip entiteta')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Numeracija:</label>
                            <input type="text" name="type_mark" class="form-control" value="{{ $data->type_mark }}" required />
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Opis oznake:</label>
                            <input type="text" name="type_description" class="form-control" value="{{ $data->type_description }}" required />
                        </div>
                    </div>
                </div>
                @endif

                <button type="submit" class="btn btn-xs btn-primary">Uredi</button>
            </form>
        </div>
    </div>
</div>