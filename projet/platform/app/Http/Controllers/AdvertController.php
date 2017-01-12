<?php //app/Http/Controllers/AdvertController.php;

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;  // Tous nos controlleurs hériteront de cette classe
use Illuminate\Http\Request;   // On charge la classe Request qui nous permettra de récupérer nos champs de formulaire et le contenu des variables d'url
use App\Models\Advert;  // On charge la class Post enregistrée dans le dossier app/Models qui fera le lien avec la table "posts"
use App\Models\Category;
use Auth;  // On charge classe Auth qui nous permettra de récupérer toutes les informations de l'utilisateur connecté
use Validator; // On charge la classe Validator qui nous permettra de valider nos champs de formulaire
use Carbon\Carbon;

class AdvertController extends Controller {


    protected function validator(array $data){

        return Validator::make($data, ['content' => 'required|max:255',
            'title' => 'min:5|max:100']);

    }


// Route::get('/advert/create','AdvertController@create')
    public function create(){

        $html = $this->getCategoryFields();



        return view('advert.create', ['categories' => $html]);

    }


// Route::post('/advert/create','AdvertController@store')
    public function store(Request $request){


        $validator = $this->validator($request->all());

        if($validator->fails() == false){

            $advert = new Advert;
            $advert->title = $request->input('title');
            $advert->content = $request->input('content');
            $advert->type = $request->input('type');
            $advert->search = $request->input('search');
            $advert->hourly_wage = $request->input('hourly_wage');
            $advert->category_id = $request->input('category_id');
            $advert->user_id = Auth::Id();


// On va créer une session flash. Le but sera d'afficher le message "Post publié avec succès!" une fois la redirection effectuée. Ce message disparaitra lorsque la page sera raffraichie.
            $request->session()->flash('success', 'Post publié avec succès!');

            $advert->save();
            return redirect('/advert/create');

        }
        else
        {

            return redirect('/advert/create')->withErrors($validator)->withInput();


        }

    }

// Route::get('/advert/{advert}/edit','AdvertController@edit')
    public function edit(Advert $advert){
        $this->checkAuthor($advert);

        $html = $this->getCategoryFields($advert);
        $data['advert'] = $advert;

        return view('advert.edit',$data, ['categories' => $html]);


    }

    public function show(Advert $advert){
        Carbon::setLocale('fr');

        return view('advert/show',['advert' => $advert]);  // On transmet au template advert/show.blade.php une variable $advert qui contiendra l'annonce à afficher

    }

    protected function checkAuthor(Advert $advert) {

        if(Auth::Id() != $advert->user_id) exit;
    }


// Route::post('/advert/{advert}/edit','PostController@update')
    public function update(Advert $advert, Request $request){


        $this->checkAuthor($advert);

        $validator = $this->validator($request->all());

        if(!$validator->fails()){
            $advert->title = $request->input('title');
            $advert->content = $request->input('content');
            $advert->type = $request->input('type');
            $advert->search = $request->input('search');
            $advert->hourly_wage = $request->input('hourly_wage');
            $advert->category_id = $request->input('category_id');
            $advert->save();
            return redirect('/');
        }
        else
        {
// S'il y a des erreurs (titre trop court) on redirige l'utilisateur sur la page d'édition du post avec les erreurs
            return redirect('advert/'.$advert->id.'/edit')->withErrors($validator);
//  La méthode withErrors permet de transmettre au template les erreurs rencontrées lors de la validation sous forme d'une variable $errors.
        }

    }


    public function index(){


        Carbon::setLocale('fr');
        $adverts = Advert::paginate(5);

        $data = ['adverts' => $adverts ,   // Dans notre template on pourra ainsi afficher les posts en faisant une boucle sur la varibale $posts
            'mainTitle' => 'Liste des annonces'];  // On aura également à disposition une variable $mainTitle qui sera égale à Liste des posts


        return view('advert/list',$data);



    }

    public function getCategoryFields(Advert $advert = null){

        $categories = Category::where('parent_id',null)->with('children')->get();

        $html = "";

        foreach($categories as $category){
            $html .= "<optgroup label='".$category->name."'>";

            foreach($category->children as $child){

                if($advert != null && $advert->category_id == $child->id) $selected = 'selected';
                else $selected ='';

                    $html .= "<option $selected value=" . $child->id . ">" . $child->name . "</option>";

            }

            $html .= "</optgroup>";


        }



        return $html;



    }


}
