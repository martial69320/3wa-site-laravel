<!-- ressources/views/post/edit.blade.php-->
@extends('layouts.app')

@section('content')
{!! Form::model($post) !!} <!-- la méthode model prend en paramètre une instance de model (exemple instance de la classe Post) et elle se chargera de remplir automatiquement tous les champs de formulaire qui lui sont associés-->
{{ csrf_field() }}
{!! Form::text('title') !!}
{!! Form::textarea('content') !!}
{!! Form::submit('Envoyer !') !!}
{!! Form::close() !!}

<!-- Pour en savoir plus sur la classe Form : https://laravelcollective.com/docs/5.2/html -->

@endsection