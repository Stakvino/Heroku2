@extends('layout')

@section('title', 'Ajouter Contact')

@section('content')

@if(count($errors) > 0)
  <div class="alert alert-danger">
  <ul>
  @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
  @endforeach
  </ul>
  </div>
@endif

<div style="margin-bottom:30px">
  <a href="{{route('fournisseur.show', $fournisseur->id)}}" class="btn btn-primary">
    Retour
  </a>
</div>

<form action="{{route('contact.store', $fournisseur->id)}}"  method="post">
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

  <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

@endsection
