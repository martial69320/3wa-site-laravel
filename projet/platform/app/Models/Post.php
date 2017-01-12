<?php  // app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Post extends Eloquent
{

    protected $with = ['author']; // A chaque fois qu'on récupérera un post on joindra les infos de son auteur

    public function author()
    {

        return $this->belongsTo('App\User','user_id'); // Laravel fera une jointure de table pour récupérer les infos de l'auteur associé à la clé étrangère user_id
        // Le premier paramètre sera la classe à laquelle la classe Post appatient.
        // Le second paramètre est la clé étrangère dans la table posts qui permet de faire le lien entre la table users et posts

        // En savoir plus sur les relations entre models: https://laravel.com/docs/5.2/eloquent-relationships

    }
}