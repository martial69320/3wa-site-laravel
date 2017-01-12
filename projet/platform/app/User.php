<?php

namespace App;

use willvincent\Rateable\Rateable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use Auth;

class User extends Authenticatable
{

    use Rateable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function adverts(){
        return $this->hasMany('App\Models\Advert');
    }

    public function reviews(){
        return $this->hasMany('App\Models\Reviews');
    }

    public function getFullNameAttribute(){  // Cette méthode sera appelé lorsque l'on cherchera à appeler la propriété inexistante "fullName"

        return $this->firstName.' '.strtoupper($this->lastName);

    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->attributes['birthday'])->age;
    }
    
    public function getDistanceAttribute()
    {
        $user = Auth::user();
        $lat1 = $user->lat;
        $lng1 = $user->lng;
        $lat2 = $this->lat;
        $lng2 = $this->lng;
        // les 2 premiers paramètres ($lat1 et $lng1) de la fonction get_distance sont les coordonnées GPS de l'utilisateur 1
        // les 2 derniers paramètres ($lat2 et $lng2) sont les coordonnées GPS de l'utilisateur 2
        return get_distance($lat1,$lng1,$lat2,$lng2);  // renverra la distance en km séparant l'utilisateur 1 (personne connectée sur le site) de l'utilisateur 2
        // get_distance a été définie dans le fichier app/helpers.php
    }

}
