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

        return response()->json($validator->errors(), 422);

      }

      $attributes = $validator->validate();

      $attributes['created_at'] = date("Y-m-d H:i:s");

      $attributes['updated_at'] = null;

      $attributes['fournisseur_id'] = $fournisseur_id;

      $contact = Contact::create( $attributes );

      $html = '
      <tr data-id="'.$contact->id.'">
        <td>'.$attributes["Nom"].'</td>
        <td>'.$attributes["Prenom"].'</td>
        <td>'.$attributes["Tel"].'</td>
        <td>'.$attributes["Fax"].'</td>
        <td>'.$attributes["Mail"].'</td>
        <td>'.$attributes["Adresse"].'</td>
        <td> 
          <a href="/fournisseurs/ajax/'.$contact->id.'/contactform" rel="modal:open">
            <i class="fa fa-edit contact-edit-icon" style="margin-right:15px"></i>
          </a> 
          <i class="fa fa-trash contact-delete-icon"></i> 
        </td>
      </tr>
      ';

      return \json_encode([
        'success_message' => 'Contact ajouter',
        'html' => $html
      ]);
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
    public function update(Request $request, Contact $contact)
    {

      $fournisseur = $contact->fournisseur;

      $validator = $this->validateData($request);

      if($validator->fails()){

        return response()->json($validator->errors(), 422);
      }
      
      $attributes = $validator->validate();

      $contact->update($attributes);

      return \json_encode(['success_message' => 'Le Contact a ete modifier']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
      
      Contact::destroy($contact->id);

      return \json_encode(['success_message' => 'Le Contact a ete supprimer']);
        
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
        'Nom.required' => 'Vous devez specifier une valeur pour le Nom',
        'Prenom.required' => 'Vous devez specifier une valeur pour le Prenom',
        'Tel.required' => 'Vous devez specifier une valeur pour Tel',
        'Tel.numeric' => 'Le Tel doit etre un numero',
        'Fax.required' => 'Vous devez specifier une valeur pour Fax',
        'Fax.numeric' => 'Le Fax doit etre un numero',
        'Mail.required' => 'Vous devez specifier une valeur pour Mail',
        'Mail.email' => 'Format incorrect du mail',
        'Adresse.required' => 'Vous devez specifier une valeur pour l\'Adresse'
      ]);
    }
}
