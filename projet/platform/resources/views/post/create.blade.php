<!-- ressources/views/post/create.blade.php-->

@extends('layouts.app')

@section('content')

    @if(Auth::User() != null)  <!-- On vérifie si l'utilisateur est connecté -->
    <!-- Si oui on affiche le formulaire de création de post -->
    {!! Form::open(['url' => 'post/create']) !!}
    {{ csrf_field() }} <!-- cette fonctio nva générer un input de type hidden contenant le jeton de session pour se protéger des attaques csrf. -->
    {!! Form::text('title',old('title')) !!} <!-- la fonction old('title') renvoiçs la valeur de l'ancien champs de formulaire "title".-->
    <!-- la fonction old ne fonctionnera que si on utilise la méthode ->withInput() lors de la redirection
    ( dans un contrôleur: return redirect('/post/create')->withErrors($validator)->withInput(); )
    -->
    {!! Form::textarea('content',old('content')) !!}
    {!! Form::submit('Envoyer !') !!}
    {!! Form::close() !!}

    @else

        <div class="alert alert-info">Vous devez être connecté.</div>

    @endif

    <!-- Pour en savoir plus sur la classe Form : https://laravelcollective.com/docs/5.2/html -->

@endsection