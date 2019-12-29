<?php

namespace App;

use App\Fournisseur;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{

  protected $guarded = [];

  public function fournisseur()
  {
    return $this->belongsTo(Fournisseur::class);
  }
}
