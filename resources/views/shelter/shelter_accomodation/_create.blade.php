<div class="modal-dialog modal-lg">
  <div class="modal-content">
         <!-- Modal Header -->
          <div class="modal-header">
              <h4 class="modal-title">Spremi smještajnu jedinicu</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <!-- Modal body -->
          <form id="storeAccomodation" method="POST" enctype="multipart/form-data"> 
            
            @method('POST')
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
                <label class="control-label">Tip Smještajne jedinice</label>
                
                <select class="js-example-basic w-100" name="accomodation_type">
                    <option selected disabled>---</option>
                    @foreach ($accomodation_types as $accomodation)
                        <option value="{{ $accomodation['id'] }}">{{ $accomodation['name'] }}</option>
                    @endforeach
                </select>   
         
            </div>
    
              <div class="form-group">
                <label>Naziv</label>
                <input type="text" class="form-control size" name="accomodation_name" id="accomodationName" placeholder="Naziv nastambe/prostora">             
              </div>
                    
            <div class="form-group">
                <label>Dimenzije</label>
                <input type="text" class="form-control size" name="accomodation_size" id="accomodationSize" placeholder="dimenzija u metrima D x Š x V">           
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Opis nastambe/prostora</label>
                {{-- <textarea class="form-control" id="accomodationDesc" name="accomodation_desc" rows="10"></textarea> --}}
                <textarea class="form-control" name="accomodation_desc"  id="accomodationDesc" rows="10"></textarea>
            </div>  
                      
            <div class="form-group">
                <label>Popratna fotodokumentacija</label>
                  <input type="file" id="accomodationPhotosCreate"  name="accomodation_photos[]" multiple />
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

