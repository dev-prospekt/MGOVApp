<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Razlog prestanka skrbi</h5>
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>

        <form action="{{ route('animalItemCareEndTypeStore') }}" method="POST" id="founder-form" enctype="multipart/form-data">
            @csrf
            @method('POST')
            
            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" name="name" class="form-control" required >
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mr-2">Dodaj</button>
            </div>

        </form>
    </div>
</div>