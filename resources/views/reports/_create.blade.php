
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Dodaj</h4>
            <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
        </div>

        <form method="POST" id="reports-ajax" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <input type="hidden" name="author" value="{{ auth()->user()->id }}">
            <input type="hidden" name="shelter" value="{{ auth()->user()->shelter->id }}">

            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="row">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label>Naziv</label>
                            <input type="text" class="form-control name" name="name">
                        </div>
                        <div class="form-group">
                            <label>Dokument</label>
                            <input type="file" id="report_file" name="report_file[]" multiple />
                            <div id="error_report_file"></div>
                        </div>

                    </div>
                </div>        
            
            </div>
    
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="submitBtn btn btn-warning">Spremi</button>
            </div>
        </form>
    </div>
</div>