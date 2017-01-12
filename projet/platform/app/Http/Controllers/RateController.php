<?php


namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Advert;
use Auth;
use App\User;
use Validator;
use App\Http\Requests\Request;
use Illuminate\Http\Request;

class RateController extends Controller{

    public function rate(Request $request, User $user){


$user = User::find($user);

$rating = new \willvincent\Rateable\Rating;
$rating->rating = $request->input('score');
$rating->user_id = \Auth::id();


        $user->ratings()->save($rating);


}





}