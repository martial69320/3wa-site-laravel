<!-- ressources/views/post/list.blade.php-->
@extends('layouts.app')

@section('content')
        <h1>{{ $mainTitle }}</h1>
        @foreach($posts as $post)
                <h2>{{ $post->title }}</h2>
                {{ $post->content }}

                <hr/>

                Auteur: {{ $post->author->name }}  | {{ $post->created_at->diffForHumans() }}
        @endforeach
                <!-- Pour en savoir plus sur la classe Form : https://laravelcollective.com/docs/5.2/html -->
                <!--
                    - La propriété author fait référance à la méthode author() définit dans la class Post
                      Elle renverra une instance de la classe User correspondant à l'auteur
                    - La méthode diffForHuman renverra la date de création du post au format "il y a 3 heures". En savoir pmlus ru la classe Carbon : http://carbon.nesbot.com/docs/
                      Pour rappel lorsque l'on récupère la propriété creadted_at ou updated_at, c'est une instance de la classe Carbon qui est renvoyée (et qui hérite de la classe DateTime)

                   -->
@endsection