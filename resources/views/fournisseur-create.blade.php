@extends('layout')

@section('title', 'Ajouter Fournisseur')

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

<form action="{{route('fournisseur.store')}}" method="post">
  @csrf
  <div class="form-group">
    <label for="Nom">Nom</label>
    <input type="text" name="Nom" class="form-control" id="Nom" placeholder="Nom"
    value="{{old('Nom')}}">
  </div>
  
  <div class="form-group">
    <label for="cp">Code Postal</label>
    <input type="text" class="form-control" name="cp" id="cp" placeholder="cp"
    value="{{old('cp')}}">
  </div>

  <div class="form-group">
    <label for="Ville">Ville</label>
    <input type="text" class="form-control" id="Ville" name="Ville" placeholder="Ville"
    value="{{old('Ville')}}">
  </div>

  <div class="form-group">
    <label for="Pays">Pays</label>
    <input type="text" class="form-control" id="Pays" placeholder="Pays" name="Pays"
    value="{{old('Pays')}}">
  </div>

  <button type="submit" class="btn btn-primary">Ajouter</button>
</form>

@endsection
