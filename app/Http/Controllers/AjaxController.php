<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Fournisseur;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function childrow(Fournisseur $fournisseur)
    {
      $adresses = $fournisseur->adresses->toArray();

      return view('ajax.child-row-contacts')->with( [
        'fournisseur' => $fournisseur,
        'adresses' => $adresses
      ] );
    }
    
    public function contactrow(Contact $contact)
    {
      
      return view('ajax.contactrow')->with(['contact' => $contact]);
    }

    public function contactform(Contact $contact)
    {
      
      return view('ajax.contactform')->with(['contact' => $contact]);
    }
}
