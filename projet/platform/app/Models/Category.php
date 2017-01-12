<?php  // app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Category extends Eloquent{


  //  protected $with = ['children'];


    public function children(){

        return $this->hasMany('App\Models\Category', 'parent_id');
    }



}