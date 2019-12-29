<form>
<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" 
class="child-row">
  <tr>
      <td class="child-row-label">Nom : </td>
      <td><input type="text" name="Nom" value="{{$fournisseur->Nom}}"></td>
  </tr>
  <tr>
      <td class="child-row-label">Adresse:</td>
      <td>
        @for($i = 0; $i < 4 ; $i++)
          @if(isset($adresses[$i]))
            <input class="adresse-input" data-id="{{$adresses[$i]['id']}}"
            type="text" name="adresse_{{$i+1}}" value="{{$adresses[$i]['adresse']}}">
          @else
            <input class="adresse-input" type="text" name="adresse_{{$i+1}}" >
          @endif
        @endfor
      </td> 
  </tr>
  <tr>
      <td class="child-row-label">Code postal:</td>
      <td><input type="text" name="cp" value="{{$fournisseur->cp}}"></td>
  </tr>
  <tr>
      <td class="child-row-label">Ville:</td>
      <td><input type="text" name="Ville" value="{{$fournisseur->Ville}}"></td>
  </tr>
  <tr>
      <td class="child-row-label">Pays:</td>
      <td><input type="text" name="Pays" value="{{$fournisseur->Pays}}"></td>
  </tr>
  <tr class="modifier-fournisseur-tr">
    <td>
      <button type="button" class="btn btn-success modifier-fournisseur-btn" 
      data-id="{{$fournisseur->id}}">
        Modifier le fournisseur
      </button>
    <td>
  </tr> 
</table>
</form>

<div class="alert alert-danger fournisseurs-errors" style="display:none">
  <ul></ul>
</div>

<div class="alert alert-success fournisseurs-success" style="display:none"></div>


<!-- Modal HTML pour ajouter contact -->
<div id="ex1" class="modal">
  
  <form class="ajouter-contact-form">
    @csrf
    <div class="form-group">
      <label for="Nom">Nom</label>
      <input type="text" name="Nom" class="form-control" id="Nom" placeholder="Nom"
      value="{{old('Nom')}}">
    </div>
    
    <div class="form-group">
      <label for="Prenom">Prenom</label>
      <input type="text" name="Prenom" class="form-control" id="Prenom" placeholder="Prenom"
      value="{{old('Prenom')}}">
    </div>

    <div class="form-group">
      <label for="Tel">Tel</label>
      <input type="text" name="Tel" class="form-control" id="Tel" placeholder="Tel"
      value="{{old('Tel')}}">
    </div>

    <div class="form-group">
      <label for="Fax">Fax</label>
      <input type="text" name="Fax" class="form-control" id="Fax" placeholder="Fax"
      value="{{old('Fax')}}">
    </div>

    <div class="form-group">
      <label for="Mail">Mail</label>
      <input type="text" class="form-control" name="Mail" id="Mail" placeholder="Mail"
      value="{{old('Mail')}}">
    </div>

    <div class="form-group">
      <label for="Adresse">Adresse</label>
      <input type="text" class="form-control" id="Adresse" name="Adresse" placeholder="Adresse"
      value="{{old('Adresse')}}">
    </div>

    <a href="#" class="btn btn-primary ajouter-contact" 
    data-id="{{$fournisseur->id}}" rel="modal:close">
      Ajouter
    </a>
  </form>

</div>

<div class="ajouter-contact-btn">
  <a href="#ex1" rel="modal:open" class="btn btn-primary">
    Ajouter un contact
  </a>
</div>

<div class="alert alert-danger contact-errors" style="display:none">
  <ul></ul>
</div>

<div class="alert alert-success contact-success" style="display:none"></div>



<!-- Modal HTML pour modifier contact -->
<div id="ex2" class="modal">
  
</div>




<div class="contacts-container">
  <h2 style="margin-bottom:15px">Contacts :</h2>
  <table class="contact-table">
  <thead>
      <tr>
          <th>Nom</th>
          <th>Prenom</th>
          <th>Tel</th>
          <th>Fax</th>
          <th>Mail</th>
          <th>Adresse</th>
          <th></th>
      </tr>
  </thead>
  <tbody>
@if(! $fournisseur->contacts->isEmpty() )

  @foreach($fournisseur->contacts as $contact)
  
  <tr data-id="{{$contact['id']}}">
    <td>{{$contact['Nom']}}</td>
    <td>{{$contact['Prenom']}}</td>
    <td>{{$contact['Tel']}}</td>
    <td>{{$contact['Fax']}}</td>
    <td>{{$contact['Mail']}}</td>
    <td>{{$contact['Adresse']}}</td>
    <td>
      <a href="/fournisseurs/ajax/{{$contact['id']}}/contactform" rel="modal:open">
        <i class="fa fa-edit contact-edit-icon" style="margin-right:15px"></i>
      </a>  
      <i class="fa fa-trash contact-delete-icon"></i> 
    </td>
  </tr>

  @endforeach

@endif
</tbody>
</table>
</div>