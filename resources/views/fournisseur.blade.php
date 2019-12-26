@extends('layout')

@section('title', $fournisseur->Nom)

@section('content')

@if (session()->has('success_message'))
  <div class="alert alert-success">
    {{ session()->get('success_message') }}
  </div>
@endif

@if($fournisseur)
  <h2 style="margin-bottom:20px">Fournisseur</h2>
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
      <tr>
        @foreach($columns as $column)
          @if($column == 'id')
            <th scope="row">{{$fournisseur->id}}</td>
          @elseif($column !== 'slug')
            <td>{{$fournisseur->$column}}</td>
          @endif
        @endforeach
      </tr>
    </tbody>
  </table>

  <div class="crud-buttons">
    <a href="{{route('contact.create', $fournisseur->id)}}">
      <button type="button" class="btn btn-success">Ajouter un contact</button>
    </a>
    <a href="{{route('fournisseur.edit', $fournisseur->slug)}}">
      <button type="button" class="btn btn-primary">Modifier Fournisseur</button>
    </a>
    <form action="{{route('fournisseur.destroy', $fournisseur->id)}}" method="post" id="delete_form">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-danger">Supprimer Fournisseur</button>
    </form>
  </div>

  @if($contacts->count())
  <h2 style="margin:60px 0 20px 0">Contacts</h2>
  <table class="table table-hover">
    <thead>
      <tr>
        @foreach($contact_columns as $contact_column)
          <th scope="col">{{$contact_column}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>    
      @foreach($contacts as $contact)
          <tr class="clickable-row" 
          onclick="window.location='{{route('contact.show', [$fournisseur->id, $contact->id])}}'">
            @foreach($contact_columns as $contact_column)
              @if($contact_column == 'id')
                <th scope="row">{{$contact->id}}</td>
              @elseif($contact_column == 'created_at')
                <td>{{$contact[$contact_column]->format("d M Y H:i:s")}}</td>
              @elseif($contact_column == 'updated_at' && $contact[$contact_column])
                <td>{{$contact[$contact_column]->format("d M Y H:i:s")}}</td>   
              @else
                <td>{{$contact->$contact_column}}</td>
              @endif
            @endforeach
          </tr>
      @endforeach
    </tbody>
  </table>

  @else
    <p style="font-size:1.5em;margin:50px 0">Aucun contact ajouter.</p>
  @endif

@else

<p style="font-size:2em;margin:50px 0" class="alert alert-danger">
  Aucun résultat trouvé
</p>

@endif

@endsection

@section('extra-js')

  <script>
    
    (function(){

      const delete_form = document.getElementById('delete_form');

      delete_form.addEventListener('submit', function(e){

        e.preventDefault();

        if(confirm('Vous voulez vraiment supprimer ce fournisseur ?')){

          this.submit();

        }

      });

    })();

  </script>

@endsection