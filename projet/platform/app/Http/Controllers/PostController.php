<?php //app/Http/Controllers/PostController.php;

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;  // Tous nos controlleurs hériteront de cette classe
use App\Models\Post;  // On charge la class Post enregistrée dans le dossier app/Models qui fera le lien avec la table "posts"
use Auth;  // On charge classe Auth qui nous permettra de récupérer toutes les informations de l'utilisateur connecté
use Validator; // On charge la classe Validator qui nous permettra de valider nos champs de formulaire
use Illuminate\Http\Request;   // On charge la classe Request qui nous permettra de récupérer nos champs de formulaire et le contenu des variables d'url

class PostController extends Controller {

    /* Cette méthode se chargera de vérifier les données de formulaire
   * envoyé par l’utilisateur lorsqu’il cherche à créer ou à éditer un post
   */
    protected function validator(array $data){

        return Validator::make($data, ['content' => 'required|max:140',
            'title' => 'min:5|max:100']);
        // Le champs content doit faire minimum 5 caractères et maximum 140 caractères
        // il existe aussi le required si l'on ne défini pas de min. (min~=required)
        // En savoir plus sur la classe Validator: https://laravel.com/docs/5.2/validation
    }

    // La méthode create servira UNIQUEMENT à afficher le formulaire d'envoi du post
    // Route à définir dans le fichier: app/Http/routes.php:
    // Route::get('/post/create','PostController@create')
    public function create(){

        return view('post.create');  // On va afficher le template create.blade.php situé dans le dossier "post"

    }

    // La méthode store servira à enregistrer en base de données le post envoyé
    // Route::post('/post/create','PostController@store')
    public function store(Request $request){
        // Post $post : signifie que le paramètre $post sera une instance de la classe Post


        // https://laravel.com/docs/5.2/validation
        $validator = $this->validator($request->all());  // La méthode all() sur l'objet $reqsuest va récupérer tous les champs de formulaire

        if($validator->fails() == false){  // S'il n'y pas d'erreur dans nos champs de formulaire on enregistre en base de données

            $post = new Post;  // On créé une instance de la classe Post  (serait nécessaire si nous n'avions pas spécifier le paramètre $post dans la méthode store
            $post->title = $request->input('title');  // alternative plus sécurisée au $_POST['title']
            $post->content = $request->input('content');
            $post->user_id = Auth::Id();   //  Auth::Id() récuperera l'id de l'utilisateur authentifié
            // $post->user_id = Auth::User()->id;  // Auth::User() renvoit une instance de la classe User correpondant à l'utilisateur authentifié
            $post->save();  // On applique la méthode save pour enregister le post dans la table "posts"

            return redirect('/post/create'); //  On redirige l'utilisateur sur la page de création des posts.
            // la fonction est un "helper" fournit par Laravel. Tous les helpers sont disponible sur https://laravel.com/docs/5.2/helpers
        }
        else
        {

            return redirect('/post/create')->withErrors($validator)->withInput();
            /* En cas d’erreur on redirige sur le formulaire de création de post.
               La méthode withErrors permet de transmettre au template les erreurs rencontrées lors de la validation.
               La méthode withErrors permet de transmettre au template les erreurs rencontrées lors de la validation sous forme d'une variable $errors. */

        }

    }

    // La méthode edit servira UNIQUEMENT à afficher le formulaire d'édition du post
    // Route::get('/post/{post}/edit','PostController@edit')
    public function edit(Post $post){  // $post sera une instance de la classe post définie par l'url tapée.
        // Lorsque l'on tape localhost/public/post/2/edit  alors le paramètre $post sera une instance de la classe Post correspondant au post ayant l'id 2 dans la table posts

        // On va vérifier que l'utilisateur cherchant à éditer le post en est bien l'auteur:
        $this->checkAuthor($post);

        $data['post'] = $post;

        return view('post.edit',$data);  // On va afficher le template post/edit.blade.php
        // Le second paramètre est un tableau associatif dont le nom des propriétés correspondra aux noms des variables qui seront disponible dans le template chargé.

    }

    protected function checkAuthor(Post $post) {

        if(Auth::Id() != $post->user_id) exit;  // Si l'id de 'lutilsiateur connecté n'est pas égale à celle de la clé étrangère user_id du post alors on stoppe l'exécution du code.

    }

    // La méthode update va enregistrer les modifications du post en base de donnée
    // Route::post('/post/{post}/edit','PostController@update')
    public function update(Post $post, Request $request){

        // On va vérifier que l'utilisateur cherchant à éditer le post en est bien l'auteur:
        $this->checkAuthor($post);

        $validator = $this->validator($request->all());  // La méthode all() sur l'objet $reqsuest va récupérer tous les champs de formulaire

        if(!$validator->fails()){
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->save(); // Vu que le post à modifier existe déjà dans la table posts, la méthode save va mettre à jours cette entrée et non l'ajouter (comme ce fut le cas dans la méthode store).
            return redirect('/');
        }
        else
        {
            // S'il y a des erreurs (titre trop court) on redirige l'utilisateur sur la page d'édition du post avec les erreurs
            return redirect('post/'.$post->id.'/edit')->withErrors($validator);
            //  La méthode withErrors permet de transmettre au template les erreurs rencontrées lors de la validation sous forme d'une variable $errors.
        }

    }

    // Afficher la page listant tous les posts
    public function index(){

        $posts = Post::all();  // On récupère tous les posts de la table posts

        // 1) Créer le template list.blade.php dans le dossier post et le faire hériter du template parent situé dans layouts/app.blade.php

        // 2) Créer la route qui permettra d'appeler la méthode index de la classe PostController . L'url sera localhost/platform/public/index.php/posts

        // 3) Dans la méthode index afficher le template post/list.blade.php et lui transmettre la variable $posts

        // 4) Dans le template post/list.blade.php faire une boucle pour afficher tous les post sous cette forme:

        /* Titre 1 du post
                 Contenu du post
                 ________________________________
          Titre 2 du post
                 Contenu du post
         ________________________________

         */

        $data = ['posts' => $posts ,   // Dans notre template on pourra ainsi afficher les posts en faisant une boucle sur la varibale $posts
            'mainTitle' => 'Liste des posts'];  // On aura également à disposition une variable $mainTitle qui sera égale à Liste des posts


        return view('post/list',$data);  // Dans le template list.blade.php nosu auront 2 variables de disponibles: $posts
        // qui contiendra tous les posts et $mainTitle qui sera égale à "Liste des posts".



    }



}





