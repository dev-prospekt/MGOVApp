
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <div class="modal-body">
            <form action="{{ route('founder-service.update', [$founderService->id]) }}" method="POST">
                @csrf
                @method('PUT')
    
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" name="name" class="form-control" value="{{ $founderService->name }}">
                        </div>
                    </div>
                </div>
    
                <button type="submit" class="btn btn-primary mr-2">Ažuriraj</button>
            </form>
        </div>
    </div>
</div>