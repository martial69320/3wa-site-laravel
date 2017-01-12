@extends('layouts.app')

@section('title')
    {{ $advert->title }}
@endsection


@section('sidebar')
        <h2>Hauteur de l'âne once</h2>
        <img src="../uploads/avatars/{{ $advert->author->id }}/thumbs_{{ $advert->author->avatar }}"/><br />
        {{ $advert->author->fullName }}<br />
        {{ $advert->author->age }} ans.<br />
        @if( $advert->author->gender == "m") Homme. @else Femme. @endif <br />
        Ville : {{ $advert->author->city }} @if(!Auth::user())
                                                "Veuillez vous connecter afin de connaitre la distance"
             @else
            + {{ $advert->author->distance }} km @endif <br />

        Note : {{ $advert->author->rate }}

@endsection


@section('content')

    <div class="well well-sm bg-info">
    <h1>{{ $advert->title }}</h1>
    {{ $advert->content }}
    <hr />
    {{ $advert->category->name }} / {{ $advert->type }} / @if( $advert->search == 1) Recherche
    @else Propose @endif <br />
    {{ $advert->created_at->diffForHumans() }}<br />
    Tarifs : {{ $advert->hourly_wage }}€/h<br />

    @if($advert->author->id == Auth()->id())
    <a class="btn btn-success" href="{{ $advert->id }}/edit">Editer</a>
    <a class="btn btn-danger" href="{{ $advert->id }}/delete">Supprimer</a>
    @endif
    </div>

@endsection