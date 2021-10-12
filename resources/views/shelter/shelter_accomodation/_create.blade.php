<div class="modal-dialog modal-lg">
  <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title">Dodaj Nastambu</h4>
          <button type="button" class="close modal-close" data-dismiss="modal">&times;</button>
      </div>
      <form method="POST" id="shelterAccomodation" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <div class="modal-body">
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
  
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                  <strong>Uspjeh!</strong> Korisnik je uspješno spremljen.
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>

              <div class="row">
                  <div class="col-md-12">
                      <div class="form-group">
                          <label>Naziv nastambe</label>
                          <input type="text" class="form-control name" name="name" id="accomodationName">
                      </div>
                      <div class="form-group">
                          <label>Dimenzije</label>
                          <input type="text" class="form-control size" name="size" id="accomodationSize">
                      </div>
                      <div class="form-group">
                        <label for="exampleFormControlTextarea1">Opis nastambe</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea>
                      </div>  
                      
                     
                        <div class="card-body">
                            <h6 class="card-title">Dropzone</h6>
                            <p class="card-description">Read the <a href="https://www.dropzonejs.com/" target="_blank"> Official Dropzone.js Documentation </a>for a full list of instructions and other options.</p>
                            <form action="/file-upload" class="dropzone" id="exampleDropzone"></form>
                          </div>
                      
                  </div>
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

