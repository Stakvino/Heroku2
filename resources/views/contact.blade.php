@extends('layout')

@section('title', $contact->Nom)

@section('content')

@if($contact)
  <div style="margin-bottom:30px">
    <a href="{{route('fournisseur.show', $fournisseur->id)}}" class="btn btn-primary">
      Retour
    </a>
  </div>

  @if (session()->has('success_message'))
    <div class="alert alert-success">
      {{ session()->get('success_message') }}
    </div>
  @endif

  <h2 style="margin-bottom:20px">Contact du fournisseur {{$fournisseur->Nom}}</h2>

  <table class="table table-hover">
    <thead>
      <tr>
        @foreach($contact_columns as $contact_column)
          <th scope="col">{{$contact_column}}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>    
      <tr>
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
    </tbody>
  </table>

  <div class="crud-buttons">
    <a href="{{route('contact.edit', [$fournisseur->id, $contact->id])}}">
      <button type="button" class="btn btn-primary">Modifier Contact</button>
    </a>
    <form action="{{route('contact.destroy', $contact->id)}}" method="post" id="delete_form">
      @csrf
      @method('delete')
      <button type="submit" class="btn btn-danger">Supprimer Contact</button>
    </form>
  </div>

@else

<p style="font-size:2em;margin:50px 0" class="alert alert-danger">
  Aucun Contact trouvé
</p>

@endif

@endsection


@section('extra-js')

  <script>
    
    (function(){

      const delete_form = document.getElementById('delete_form');

      delete_form.addEventListener('submit', function(e){

        e.preventDefault();

        if(confirm('Vous voulez vraiment supprimer ce contact ?')){

          this.submit();

        }

      });

    })();

  </script>

@endsection