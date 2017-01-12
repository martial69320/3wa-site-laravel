<!-- ressources/views/advert/edit.blade.php-->
@extends('layouts.app')

@section('content')

 <div class="container">
  <div class="row">
   <div class="col-md-12">
    <div class="panel panel-default">

     <div class="panel-body">


     @if(Auth::User() != null)  <!-- On vérifie si l'utilisateur est connecté -->
      <!-- Si oui on affiche le formulaire de création de post -->


      @else

       <div class="alert alert-info">Vous devez être connecté.</div>

      @endif
     </div>
    </div>
   </div>
  </div>
 </div>


@endsection