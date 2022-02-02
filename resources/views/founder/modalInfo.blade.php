<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
            
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
    
                <div class="row mt-3">
                    <div class="col-md-12">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Služba/osoba koja je izvršila predaju u oporavilište</label>
                                    <select id="sluzba" class="form-control" disabled>
                                        <option selected value="{{ $founder->founderServices->id }}">{{ $founder->founderServices->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" id="ostalo">
                                <div class="form-group">
                                    <label>Ostalo navesti</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->others }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ime</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->name }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prezime</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->lastname }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Adresa</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->address }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Država (prebivališta)</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->country }}" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kontakt mobitel/telefon</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->contact }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email adresa</label>
                                    <input disabled type="text" class="form-control" value="{{ $founder->email }}" >
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>

    </div>
</div>