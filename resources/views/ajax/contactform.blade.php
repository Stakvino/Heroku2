<form class="modifier-contact-form" data-id="{{$contact->id}}">
  @csrf
  <div class="form-group">
    <label for="Nom">Nom</label>
    <input type="text" name="Nom" class="form-control" id="Nom" placeholder="Nom"
    value="{{$contact->Nom}}">
  </div>
  
  <div class="form-group">
    <label for="Prenom">Prenom</label>
    <input type="text" name="Prenom" class="form-control" id="Prenom" placeholder="Prenom"
    value="{{$contact->Prenom}}">
  </div>

  <div class="form-group">
    <label for="Tel">Tel</label>
    <input type="text" name="Tel" class="form-control" id="Tel" placeholder="Tel"
    value="{{$contact->Tel}}">
  </div>

  <div class="form-group">
    <label for="Fax">Fax</label>
    <input type="text" name="Fax" class="form-control" id="Fax" placeholder="Fax"
    value="{{$contact->Fax}}">
  </div>

  <div class="form-group">
    <label for="Mail">Mail</label>
    <input type="text" class="form-control" name="Mail" id="Mail" placeholder="Mail"
    value="{{$contact->Mail}}">
  </div>

  <div class="form-group">
    <label for="Adresse">Adresse</label>
    <input type="text" class="form-control" id="Adresse" name="Adresse" placeholder="Adresse"
    value="{{$contact->Adresse}}">
  </div>

  <a href="#" class="btn btn-primary modifier-contact" 
  data-id="{{$contact->fournisseur->id}}" rel="modal:close">
    Modifier
  </a>
</form>
