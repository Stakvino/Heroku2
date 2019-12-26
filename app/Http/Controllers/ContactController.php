<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($fournisseur_id)
    {
        $fournisseur = Fournisseur::find($fournisseur_id);

        return view('contact-create')->with( compact('fournisseur') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $fournisseur_id)
    {
      
      $validator = $this->validateData($request);
      
      if($validator->fails()){

        return redirect()->route('contact.create', $fournisseur_id)
        ->withErrors($validator);

      }

      $attributes = $validator->validate();

      $attributes['created_at'] = date("Y-m-d H:i:s");

      $attributes['updated_at'] = null;

      $attributes['fournisseur_id'] = $fournisseur_id;

      $contact = Contact::create( $attributes );

      session()->flash('success_message', 'Contact Ajouter');

      return redirect()->route('fournisseur.show', $fournisseur_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Fournisseur $fournisseur, Contact $contact)
    {
        $contact_columns = \Schema::getColumnListing('contacts');

        return view('contact')->with([

          'contact' => $contact,

          'contact_columns' => $contact_columns,

          'fournisseur' => $contact->fournisseur

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit($fournisseur_id, Contact $contact)
    { 
        return view('contact-edit')->with( compact('fournisseur_id', 'contact') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fournisseur $fournisseur, Contact $contact)
    {
      
      $columns = \Schema::getColumnListing('contacts');

      $validator = $this->validateData($request);

      if($validator->fails()){

        return view('contact-edit')
        ->withErrors($validator)
        ->with( ['fournisseur_id' => $fournisseur->id, 'contact' => $contact] );

      }
      
      $attributes = $validator->validate();

      $attributes['updated_at'] = date("Y-m-d H:i:s");

      $contact->update($attributes);

      session()->flash('success_message', 'Contact modifier');
    
      return redirect()->route('contact.show', [
        'fournisseur' => $fournisseur->id,
        'contact' => $contact->id
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
      
      $fournisseur_id = $contact->fournisseur_id; 

      Contact::destroy($contact->id);

      session()->flash('success_message', 'Contact Supprimer');

      return redirect()->route('fournisseur.show', $fournisseur_id);
        
    }

    public function validateData($request)
    {
      
      return Validator::make($request->all(), [
        'Nom' => 'required',
        'Prenom' => 'required',
        'Tel' => 'required|numeric',
        'Fax' => 'required|numeric',
        'Mail' => 'required|email',
        'Adresse' => 'required',
      ],
      [
        'Nom.required' => 'Vous devez spécifier une valeur pour le Nom',
        'Prenom.required' => 'Vous devez spécifier une valeur pour le Prenom',
        'Tel.required' => 'Vous devez spécifier une valeur pour Tel',
        'Tel.numeric' => 'Le Tel doit être un numéro',
        'Fax.required' => 'Vous devez spécifier une valeur pour Fax',
        'Fax.numeric' => 'Le Fax doit être un numéro',
        'Mail.required' => 'Vous devez spécifier une valeur pour Mail',
        'Mail.email' => 'Format incorrect du mail',
        'Adresse.required' => 'Vous devez spécifier une valeur pour l\'Adresse'
      ]);
    }
}
