@extends('layout')

@section('title', 'Modifier Fournisseur')

@section('content')

@if($fournisseur)

<div style="margin-bottom:30px">
  <a href="{{route('fournisseur.show', $fournisseur->id)}}" class="btn btn-primary">
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

<form action="{{route('fournisseur.patch', $fournisseur->id)}}" method="post">
  @csrf
  @method('patch')
  <div class="form-group">
    <label for="Nom">Nom</label>
    <input type="text" name="Nom" class="form-control" id="Nom" placeholder="Nom"
    value="{{$fournisseur->Nom}}">
  </div>
  
  <div class="form-group">
    <label for="cp">Code Postal</label>
    <input type="text" class="form-control" name="cp" id="cp" placeholder="cp"
    value="{{$fournisseur->cp}}">
  </div>

  <div class="form-group">
    <label for="Ville">Ville</label>
    <input type="text" class="form-control" id="Ville" name="Ville" placeholder="Ville"
    value="{{$fournisseur->Ville}}">
  </div>

  <div class="form-group">
    <label for="Pays">Pays</label>
    <input type="text" class="form-control" id="Pays" placeholder="Pays" name="Pays"
    value="{{$fournisseur->Pays}}">
  </div>

  <button type="submit" class="btn btn-primary">Modifier</button>
</form>

@else

<p style="font-size:2em;margin:50px 0" class="alert alert-danger">
  Aucun résultat trouvé
</p>

@endif

@endsection
