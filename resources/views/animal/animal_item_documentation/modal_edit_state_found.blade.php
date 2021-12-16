<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Stanje jedinke u trenutku pronalaska</h5>
          <button type="button" class="close modal-close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
          </button>
      </div>
      <form action="{{ route('shelters.animal_groups.animal_items.animal_item_documentations.update', [$shelter, $animalGroup, $animalItem, $itemDocumentation]) }}" method="POST" id="updateStateFound" enctype="multipart/form-data">
          @csrf
          @method('PUT')         
          <div class="modal-body">
              <div id="dangerStateFound" class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div id="successStateFound" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                  <strong>Uspjeh!</strong> Uspješno spremljeno.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>     
              
              <div class="form-group">
                <label>Stanje u kojem je životinja pronađena</label>
                {{ $itemDocumentation->state_found }}
                <select name="edit_state_found" class="form-control">

                    <option value="{{ $itemDocumentation->state_found}}" {{ ( $itemDocumentation->state_found == $selectedState) ? 'selected' : '' }}>{{ $itemDocumentation->state_found  }}</option>
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
                <textarea class="form-control" id="exampleFormControlTextarea1" name="state_found_desc" rows="8">{{ $itemDocumentation->state_found_desc }}</textarea>
            </div>
            <div class="form-group">
                <label>Upload <strong>(JPG, PNG)</strong></label>
                <input type="file" id="stateFoundFile" name="edit_state_found_file[]" multiple />
                <div id="error_edit_state_file"></div>
            </div>        
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-warning mr-2">Dodaj zapis</button>
          </div>
      </form>
  </div>
</div>