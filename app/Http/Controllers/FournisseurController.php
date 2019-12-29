<?php

namespace App\Http\Controllers;

use App\Adress;
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
        return view('fournisseurs');
    }

    public function getFournisseurs()
    {
      $fournisseurs = Fournisseur::all();
      
      foreach ($fournisseurs as $fournisseur) {

        $fournisseur['adresses'] = $fournisseur->adresses;

        $contacts = Contact::where('fournisseur_id', $fournisseur->id)->get();  

        $fournisseur['contacts'] = $contacts;

      }

      return [ 'data' => $fournisseurs ];
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

      //Create adresses
      $adresses_count = 4;

      for ($i=1; $i <= $adresses_count; $i++) { 
        
        $adresse = request()->get('adresse_'.$i);

        if($adresse){

          Adress::create( [ 'adresse' => $adresse, 'fournisseur_id' => $fournisseur->id ] );

        }

      }

      session()->flash('success_message', 'Fournisseur Ajouter');

      return redirect()->route('fournisseur.index');
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

      $fournisseur = Fournisseur::find($id);

      $validator = $this->validateData($request);

      if($validator->fails()){

        return response()->json($validator->errors(), 422);
      }
      
      $attributes = $validator->validate();

      $attributes['ModifieLe'] = date("Y-m-d H:i:s");

      $attributes['ModifiePar'] = 'khatir';

      $fournisseur->update($attributes);

      //Create adresses
      $adresses_count = 4;
      
      for ($i=1; $i <= $adresses_count; $i++) { 
        
        $adresse = request()->get('adresse_'.$i);

        $adresse = $adresse ? $adresse : '';

        $adresse_id = request()->get('adresse_id_'.$i);

        if($adresse){
          if($adresse_id){
            Adress::find($adresse_id)->update(['adresse' => $adresse]);
          }else{
            Adress::create(['adresse' => $adresse, 'fournisseur_id' => $id]);
          }
        }

      }

      return \json_encode(['success_message' => 'Le Fournisseur a ete modifier']);
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
        'Nom.required' => 'Vous devez specifier une valeur pour le Nom',
        'cp.required' => 'Vous devez specifier une valeur pour le Code Postal',
        'cp.numeric' => 'Le Code Postal doit etre un numero',
        'Ville.required' => 'Vous devez specifier une valeur pour la Ville',
        'Pays.required' => 'Vous devez specifier une valeur pour le Pays',
      ]);
    }
}
