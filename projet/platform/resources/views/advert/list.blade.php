<!-- ressources/views/advert/list.blade.php-->
@extends('layouts.app')

@section('content')
    <h1>{{ $mainTitle }}</h1>
    @foreach($adverts as $advert)
        <a href="advert/{{ $advert->id }}"><h2>{{ $advert->title }}</h2></a>
        {{ str_limit($advert->content, 100) }}

        <hr/>

        Auteur: {{ $advert->author->name }}  | {{ $advert->created_at->diffForHumans() }}
    @endforeach

    {{  $adverts->links() }}


@endsection