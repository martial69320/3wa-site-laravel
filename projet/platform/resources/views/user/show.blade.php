@extends('layouts.app')

@section('title')
    {{ $user->fullName }}
@endsection


@section('sidebar')

    <img src="../uploads/avatars/{{ $user->id }}/thumbs_{{ $user->avatar }}"/><br />
    {{ $user->fullName }}<br />
    {{ $user->age }} ans.<br />
    @if( $user->gender == "m") Homme. @else Femme. @endif <br />
    Ville : {{ $user->city }} @if(!Auth::user())
        "Veuillez vous connecter afin de connaitre la distance"
    @else
        + {{ $user->distance }} km @endif <br />
        <?php

        $average = round($user->averageRating, 0);

        ?>
    Note :  @if($average >= 5)
        ✮✮✮✮✮
            @elseif($average == 4)
        ✮✮✮✮
            @elseif($average == 3)
        ✮✮✮
            @elseif($average == 2)
        ✮✮
            @elseif($average == 1)
        ✮
            @else
        Aucune note
    @endif
    ({{ $user->ratings->count() }})<br />

    @if($user->id == Auth()->id())
        <a class="btn btn-success" href="{{ url('profile') }}">Editer</a>
    @endif

    {{ number_format($user->averageRating, 2) }}


@endsection


@section('content')

    <div class="row">
        <div class="col-md-12 well well-lg">
            <h1>Profile de {{ $user->fullName }}</h1>
            <h2>Description de {{ $user->name }}</h2>
            <p>"{{ $user->description }}"</p>

            @foreach($user->adverts as $advert)
            {{ $advert->title }}<br />
            @endforeach
        </div>
    </div>

@endsection