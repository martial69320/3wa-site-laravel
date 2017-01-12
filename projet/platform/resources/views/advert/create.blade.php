<!-- ressources/views/post/create.blade.php-->

@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">


    @if(Auth::User() != null)<!-- On vérifie si l'utilisateur est connecté -->
    <!-- Si oui on affiche le formulaire de création de post -->
    {!! Form::open(['url' => 'advert/create']) !!}
    {{ csrf_field() }} <!-- cette fonctio nva générer un input de type hidden contenant le jeton de session pour se protéger des attaques csrf.
     -->


    {!! Form::radio('search', 1, true)!!}Je Recherche
    {!! Form::radio('search', 0)!!}  Je propose<br><br>
    {!! Form::text('title',old('title'),array('placeholder'=>'Titre' )) !!} <br><br>
    {!! Form::textarea('content',old('content'),array('placeholder'=>'Description' )) !!}<br>
    {!! Form::radio('type','JOB',true) !!} JOB &nbsp; &nbsp;
    {!! Form::radio('type','STAGE',true) !!} STAGE &nbsp; &nbsp;
    {!! Form::radio('type','INTERIM',true) !!} INTERIM &nbsp; &nbsp;
    {!! Form::radio('type','CDD',true) !!} CDD &nbsp; &nbsp;
    {!! Form::radio('type','CDI',true) !!} CDI &nbsp; &nbsp;
    {!! Form::radio('type','PRESTA',true) !!} PRESTA &nbsp; &nbsp;<br><br>
    TARIF {!! Form::text('hourly_wage',old('hourky_wage'),array('placeholder'=>'XX' )) !!} €/hr <br><br>
    <select name="category_id">
        {!!  $categories !!}
    </select>




        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-6">
                <button type="button" class="btn btn-success">{!! Form::submit('PUBLIER') !!}</button>
                </div>
                </div>
            </div>

    {!! Form::close() !!}

    @else

        <div class="alert alert-info">Vous devez être connecté.</div>

    @endif
</div>
    </div>
    </div>
    </div>
    </div>


@endsection

@section('sidebar')
    Mes annonces :<br />
    @foreach(Auth::User()->adverts as $advert)
        <a href="{{ $advert->id }}/edit">{{ $advert->title }}</a><br />
        {{ $advert->type }} | {{ $advert->category->name }}
        <hr />
    @endforeach

    @endsection