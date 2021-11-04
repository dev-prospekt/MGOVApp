<!-- Update Staffs Modal -->
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
           <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Izmjeni smještajnu jedinicu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <form id="updateAccomodation" method="POST" enctype="multipart/form-data"> 
              @method('PUT')
              @csrf
               
            <div class="modal-body">
              
                <div id="dangerAccomodationUpdate" class="alert alert-danger alert-legal-staff alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="successAccomodationUpdate" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Uspjeh!</strong> Smještajna jedinica uspješno spremljena.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
      
                <div class="form-group">
                  <label>Naziv</label>
                  <input type="text" class="form-control size" name="edit_accomodation_name" id="updateAccomodationName" placeholder="Naziv nastambe npr. Kavez 01" value="{{ $shelterAccomodationItem->name }}">             
                </div>
                      
              <div class="form-group">
                  <label>Dimenzije</label>
                  <input type="text" class="form-control size" name="edit_accomodation_size" id="updateAccomodationSize" placeholder="dimenzija u metrima D x Š x V" value="{{ $shelterAccomodationItem->dimensions }}">           
              </div>

                    <div class="modal-body">
                    
                        <div id="dangerAccomodationUpdate" class="alert alert-danger alert-legal-staff alert-dismissible fade show" role="alert" style="display: none;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="successAccomodationUpdate" class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                            <strong>Uspjeh!</strong> Smještajna jedinica uspješno spremljena.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
            
                        <div class="form-group">
                        <label>Naziv</label>
                        <input type="text" class="form-control size" name="edit_accomodation_name" id="updateAccomodationName" placeholder="Naziv nastambe npr. Kavez 01" value="{{ $shelterAccomodationItem->name }}">             
                        </div>
                            
                    <div class="form-group">
                        <label>Dimenzije</label>
                        <input type="text" class="form-control size" name="edit_accomodation_size" id="updateAccomodationSize" placeholder="dimenzija u metrima D x Š x V" value="{{ $shelterAccomodationItem->dimensions }}">           
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Opis nastambe</label>
                        <textarea class="form-control" id="updateAccomodationDesc" name="edit_accomodation_desc" rows="8">{{ $shelterAccomodationItem->description }}</textarea>
                    </div>  
                                
                    <div class="form-group">
                        <label>Popratna fotodokumentacija</label>
                            <input  name="edit_accomodation_photos[]" type="file" id="updateAccomodationPhotos" multiple>
                    </div>

                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" class="submitBtn btn btn-warning">Spremi</button>
                  <button type="button" class="btn btn-primary modal-close" data-dismiss="modal">Zatvori</button>
                </div>
        </form>
    </div>
  </div>
