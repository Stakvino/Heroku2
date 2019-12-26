@extends('layout')

@section('title', 'Modifier Contact')

@section('content')

@if($contact)

<div style="margin-bottom:30px">
  <a href="{{route('contact.show', [$fournisseur_id, $contact->id])}}" class="btn btn-primary">
    Retour
  </a>
</div>

@if(count($errors) > 0)
  <div class="alert alert-danger">
  <ul>
  @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
  </ul>
  </div>
@endif

<form action="{{route('contact.patch', [$fournisseur_id, $contact->id])}}" method="post">
  @csrf
  @method('patch')
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


  <button type="submit" class="btn btn-primary">Modifier</button>
</form>

@else

<p style="font-size:2em;margin:50px 0" class="alert alert-danger">
  Aucun résultat trouvé
</p>

@endif

@endsection
