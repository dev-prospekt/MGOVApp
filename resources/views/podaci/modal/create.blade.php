
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ $route }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" name="name" class="form-control" required />
                        </div>
                    </div>
                </div>

                @if($model == 'Vrsta oznake')
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Opis</label>
                            <input type="text" name="desc" class="form-control" required />
                        </div>
                    </div>
                </div>
                @endif

                <button type="submit" class="btn btn-xs btn-primary">Uredi</button>
            </form>
        </div>
    </div>
</div>