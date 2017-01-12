<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Auth;
use Image;
use Carbon\Carbon;



class UserController extends Controller {

    /*
     * Enregistrer un nouvel utilisateur.
     */
    public function store(Request $request){

        $validation = $this->validator($request->all());

        $json=file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$request->input("zipcode").'%20france');
        $data = json_decode($json,true);
        //$city = $data['results'][0]['address_components'][1]['long_name'];
        $lat = $data['results'][0]['geometry']['location']['lat'];
        $lng = $data['results'][0]['geometry']['location']['lng'];
        $city = $data['results'][0]['address_components'][1]['long_name']; // permet de cibler la ville

        if(!$validation->fails()){

            $user = new User;
            $user->name = $request->input('name');
            $user->firstname= $request->input('firstname');
            $user->lastname = $request->input('lastname');
            $user->gender = $request->input('gender');

            $user->email = $request->input('email');
            $user->zipcode = $request->input('zipcode');
            $user->birthday = $request->input('birthday');
            $user->password = bcrypt($request->input('password'));  // On crypte le mot de passe en blowfish
           // $user->city = $request->city;
            $user->lat= $lat;
            $user->lng=$lng;
            $user->city=$city;
            

            // Il faudra rajouter plus tard les autres champs stipulés dans le cahier des charges (zipcode, lastname etc.)


            $user->save();
            
            // Une fois enregistré en base de donnée on connecte autimatiquement l'utilisateur.
            Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], true);
            // Le 3ème paramètre (true) signifie qu'on souhaite connecter automatiquement l'utilisateur s'il revient ultérieurement sur le site.
            // En savoir plus sur la classe Auth: https://laravel.com/docs/5.2/authentication
            mkdir('uploads/avatars/'.Auth::id(), 0777);
            $file = 'default.jpg';
            $newfile = 'default.jpg';

            copy('uploads/avatars/'.$file, 'uploads/avatars/'.Auth::id().'/'.$newfile);
            copy('uploads/avatars/thumbs_'.$file, 'uploads/avatars/'.Auth::id().'/thumbs_'.$newfile);
            copy('uploads/avatars/medium_'.$file, 'uploads/avatars/'.Auth::id().'/medium_'.$newfile);
            return redirect('/');  // On redirige sur la page d'accueil


        }
        else
        {
            return redirect('/register')->withInput()->withErrors($validation);
        }

    }

    public function show(User $user){


        return view('user/show',['user' => $user]);  // On transmet au template advert/show.blade.php une variable $advert qui contiendra l'annonce à afficher

    }


    public function edit(User $user){

        $data['users'] = $user;

        return view('user.edit',$data);


    }

    public function index(){

        $users = User::paginate(5);

        $data = ['users' => $users ,   // Dans notre template on pourra ainsi afficher les posts en faisant une boucle sur la varibale $posts
            'mainTitle' => 'Liste des utilisateurs'];  // On aura également à disposition une variable $mainTitle qui sera égale à Liste des posts


        return view('user/list',$data);



    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:5|max:25|unique:users|alpha_num',
            'firstname'=>'required|min:1|max:50|alpha_num',
            'lastname'=>'required|min:1|max:50|alpha_num',
            'gender'=>'required|in:m,f',
            'email' => 'required|email|max:255|unique:users',
            'zipcode'=>'required|numeric',
            'birthday' => 'required|date|before:-18 years',
            'password' => 'required|min:6|confirmed',

        ]);
    }







}

?>