<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $number_of_elements = 10;

        if(request()->has('afficher-elements')){

          $number_of_elements = request()->get('afficher-elements');
        
        }

        $query_url = substr(url()->full(), strlen(url()->current()) );
        
        if($query_url == ""){

          header('location: /?afficher-elements=10');
          die();

        }

        $fournisseurs = Fournisseur::search($number_of_elements);

        if($fournisseurs->currentPage() > $fournisseurs->lastPage() ){

          $redirect_url = preg_replace('/page=[^&]+/', 'page=1', $query_url);
          
          header('location: '.$redirect_url);
          die();
        }
        
        $fournisseurs = Fournisseur::formatDate($fournisseurs);

        $links = $fournisseurs->appends(request()->input())->links();

        $columns = \Schema::getColumnListing('fournisseurs');

        return view('fournisseurs')
        ->with([
           
          'fournisseurs' => $fournisseurs,

          'columns' => $columns,

          'links' => $links

          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('fournisseur-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $validator = $this->validateData($request);
      
      if($validator->fails()){

        return redirect()->route('fournisseur.create')
        ->withErrors($validator);

      }

      $attributes = $validator->validate();

      $attributes['slug'] = Fournisseur::makeSlug($attributes['Nom']);

      $attributes['CreeLe'] = date("Y-m-d H:i:s");

      $fournisseur = Fournisseur::create( $attributes );

      session()->flash('success_message', 'Fournisseur Ajouter');

      return redirect()->route('fournisseur.show', $fournisseur->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $columns = \Schema::getColumnListing('fournisseurs');

        $fournisseur = Fournisseur::where('id', $id)->firstOrFail();
        
        $fournisseur = Fournisseur::formatDate([$fournisseur])[0];

        $contacts = Fournisseur::find($id)->contacts;

        $contact_columns = \Schema::getColumnListing('contacts');

        return view('fournisseur')
        ->with([

          'columns' => $columns,

          'fournisseur' => $fournisseur,

          'contacts' => $contacts,

          'contact_columns' => $contact_columns
          ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {

        $fournisseur = Fournisseur::where('slug', $slug)->firstOrFail();

        return view('fournisseur-edit')->with( compact('fournisseur') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

      $columns = \Schema::getColumnListing('fournisseurs');

      $fournisseur = Fournisseur::find($id);

      $validator = $this->validateData($request);

      if($validator->fails()){

        return view('fournisseur-edit')
        ->withErrors($validator)
        ->with( compact('fournisseur') );

      }
      
      $attributes = $validator->validate();

      $attributes['ModifieLe'] = date("Y-m-d H:i:s");

      $attributes['ModifiePar'] = 'khatir';

      $fournisseur->update($attributes);

      session()->flash('success_message', 'Le Fournisseur a été modifier');
    
      return redirect()->route('fournisseur.show', $fournisseur->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fournisseur  $fournisseur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Fournisseur::destroy($id);

      session()->flash('success_message', 'Fournisseur Supprimer');

      return redirect()->route('fournisseur.index');
    }

    public function validateData($request)
    {
      
      return Validator::make($request->all(), [
        'Nom' => 'required',
        'cp' => 'required|numeric',
        'Ville' => 'required',
        'Pays' => 'required'
      ],
      [
        'Nom.required' => 'Vous devez spécifier une valeur pour le Nom',
        'cp.required' => 'Vous devez spécifier une valeur pour le Code Postal',
        'cp.numeric' => 'Le Code Postal doit être un numéro',
        'Ville.required' => 'Vous devez spécifier une valeur pour la Ville',
        'Pays.required' => 'Vous devez spécifier une valeur pour le Pays',
      ]);
    }
}
