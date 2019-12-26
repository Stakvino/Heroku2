<?php

namespace App;

use App\Contact;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function contacts()
    {
      return $this->hasMany(Contact::class);
    }

    public static function search($number_of_elements)
    {
              
      $search_keys = ['id', 'Nom', 'cp', 'Pays', 'Ville'];

      $match_array = [];

      foreach($search_keys as $search_key){

        if(request()->has($search_key)){

          $match_array[$search_key] = request()->get($search_key); 

        }

      }
      
      if(! empty($match_array) ){

        $fournisseurs = Fournisseur::orderBy('CreeLe', 'DESC')->where($match_array)
        ->paginate($number_of_elements);

      }else{

        $fournisseurs = Fournisseur::orderBy('CreeLe', 'DESC')->paginate($number_of_elements);

      }

      return $fournisseurs;

    }

    public static function makeSlug($name)
    {
      
      return $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));

    }

    public static function formatDate($fournisseurs)
    {
      foreach($fournisseurs as $fournisseur){

        $cree_le = date_create($fournisseur['CreeLe']);
        
        $fournisseur['CreeLe'] = date_format($cree_le,"d M Y H:i:s");
        
        if($fournisseur['ModifieLe']){

          $modifie_le = date_create($fournisseur['ModifieLe']);

          $fournisseur['ModifieLe'] = date_format($modifie_le,"d M Y H:i:s"); 

        }
      } 

      return $fournisseurs;
    }

}
