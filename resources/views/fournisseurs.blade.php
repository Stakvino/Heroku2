@extends('layout')

@section('title', 'Fournisseurs')

@section('content')

@if (session()->has('success_message'))
  <div class="alert alert-success">
    {{ session()->get('success_message') }}
  </div>
@endif

<h2>Recherche detaillée:</h2>

<div class="row search-forms">
  <form class="form-inline md-form form-sm active-pink-2 mt-2 search-form">
    @csrf
    <input class="form-control form-control-sm mr-3 w-75 search-input" type="text" placeholder="Code"
      aria-label="Search" name="id"
      value="{{ request()->has('id') ? request()->get('id') : ''}}">
  </form>
  
  <form class="form-inline md-form form-sm active-pink-2 mt-2 search-form">
    @csrf
    <input class="form-control form-control-sm mr-3 w-75 search-input" type="text" placeholder="code postal"
      aria-label="Search" name="cp"
      value="{{ request()->has('cp') ? request()->get('cp') : ''}}">
  </form>
  
  <form class="form-inline md-form form-sm active-pink-2 mt-2 search-form">
    @csrf
    <input class="form-control form-control-sm mr-3 w-75 search-input" type="text" placeholder="Nom"
      aria-label="Search" name="Nom"
      value="{{ request()->has('Nom') ? request()->get('Nom') : ''}}">
      
  </form>
  
  <form class="form-inline md-form form-sm active-pink-2 mt-2 search-form">
    @csrf
    <input class="form-control form-control-sm mr-3 w-75 search-input" type="text" placeholder="Pays"
      aria-label="Search" name="Pays"
      value="{{ request()->has('Pays') ? request()->get('Pays') : ''}}">
  </form>

  <form class="form-inline md-form form-sm active-pink-2 mt-2 search-form">
    @csrf
    <input class="form-control form-control-sm mr-3 w-75 search-input" type="text" placeholder="Ville"
      aria-label="Search" name="Ville"
      value="{{ request()->has('Ville') ? request()->get('Ville') : ''}}">
  </form>
</div>

<div class="afficher-elements">
Afficher 
<form action="{{route('fournisseur.index.post')}}" method="post" 
style="display:inline" id="afficher-elements-form">
  @csrf
  <select name="afficher-elements" id="afficher-elements-select">
    @for($i = 10; $i < 60; $i += 10)
      <option value="{{$i}}" 
      {{ request()->has('afficher-elements') 
      &&  request()->get('afficher-elements') == $i ? 
      'selected' : ''}} >
        {{$i}}
      </option>
    @endfor
  </select>
</form>
éléments
</div>

<div class="row" style="margin: 20px 0">
    <a class="btn btn-success"  
    href="{{route('fournisseur.create')}}">
      Ajouter un Fournisseur
    </a>
</div>

@if($fournisseurs->count())
<table class="table table-hover">
  <thead>
    <tr>
      @foreach($columns as $column)
        @if($column !== 'slug')
          <th scope="col">{{$column}}</th>
        @endif
      @endforeach
    </tr>
  </thead>
  <tbody>    
    @foreach($fournisseurs as $fournisseur)
        <tr class="clickable-row" 
        onclick="window.location='{{route('fournisseur.show', $fournisseur->id)}}'">
          @foreach($columns as $column)
            @if($column == 'id')
              <th scope="row">{{$fournisseur->id}}</td>
            @elseif($column !== 'slug')
              <td>{{$fournisseur->$column}}</td>
            @endif
          @endforeach
        </tr>
    @endforeach
  </tbody>
</table>
@else
  <p style="font-size:2em;margin:50px 0" class="alert alert-danger">
    Aucun résultat trouvé
  </p>
@endif
<div class="pagination" style="margin-top:30px">
   {!! $links !!}     
</div>

@endsection

@section('extra-js')
  <script>

    (function(){


      const afficher_elements_select = document.getElementById('afficher-elements-select');
            
      afficher_elements_select.addEventListener('change', function(){

        let current_location = window.location.href;

        current_location = current_location.replace(/afficher-elements=[^&]+/,
         `afficher-elements=${afficher_elements_select.value}`);

        window.location.href = current_location;
      });  

      const search_forms = document.querySelectorAll('.search-form');

      const search_inputs = document.querySelectorAll('.search-input');

      search_forms.forEach(function(search_form){

        search_form.addEventListener('submit', function(e){

          e.preventDefault();

          let current_url = window.location.href;

          search_inputs.forEach(function(search_input){
              
            const key = search_input.name;

            const url_regex = new RegExp(key + '=([^&]+)');

            const value = search_input.value.trim();

            const match = current_url.match(url_regex);

            if(value){

              if(match){

                current_url = current_url.replace(url_regex, `${key}=${value}`);

              }else{

                current_url = current_url + `&${key}=${value}`;

              }

            }else{

              current_url = current_url.replace(new RegExp('&?' + key + '=([^&]+)'), ``);

            }

          });

          
          window.location.href = current_url;

        });

      });

    })();

  </script>
@endsection