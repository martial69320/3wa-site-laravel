<?php  // app/Models/Advert.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Advert extends Eloquent {


    protected $with = ['author','category']; // On récupère dans la foumlu (via une jointure de table) l'auteur et la catégorie de 'lannonce.

    public function author(){

        return $this->belongsTo('App\User','user_id');

    }

    public function category(){

        return $this->belongsTo('App\Models\Category');

    }

}