<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Stanje jedinke u trenutku zaprimanja</h5>
          <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
      </div>
      <form action="{{ route('shelters.animal_groups.animal_items.animal_item_documentations_recived.store', [$shelter, $animalGroup, $animalItem]) }}" method="POST" id="storeStateRecived" enctype="multipart/form-data">
          @csrf
          @method('POST')         
          <div class="modal-body">
              <div id="dangerStateRecived" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div id="successStateRecived" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                  <strong>Uspjeh!</strong> Uspješno spremljeno.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>     
             
              <div class="form-group">
                <label>Stanje u kojem je životinja pronađena</label>
                <select name="state_recived" class="form-control">
                    <option value="">----</option>
                    <option value="iscrpljena/dehidrirana-bez vanjskih ozljeda">iscrpljena/dehidrirana-bez vanjskih ozljeda</option>
                    <option value="ozlijeđena/ranjena">ozlijeđena/ranjena</option>
                    <option value="otrovana">otrovana</option>
                    <option value="bolesna">bolesna</option>
                    <option value="uginula">uginula</option>
                    <option value="ostalo">ostalo</option>
                </select>
            </div>
            <div class="form-group">
                <label>Opis</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="state_recived_desc" rows="8"></textarea>
            </div>
            <div class="form-group">
                <label>Upload <strong>(JPG, PNG)</strong></label>
                <input type="file" id="stateRecivedFile" name="state_recived_file[]" multiple />
                <div id="error_state_recived_file"></div>
            </div>        
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-warning mr-2">Dodaj zapis</button>
          </div>
      </form>
  </div>
</div>