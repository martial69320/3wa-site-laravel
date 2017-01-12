@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <form id="update" enctype="multipart/form-data" class="form-horizontal" role="form" method="POST" action="{{ url('/profile') }}">


                        {{ csrf_field() }}

                            <img src="uploads/avatars/{{ $user->id }}/{{ $user->avatar }}" style="width:150px; height:150px; border-radius:50%; margin-right:25px;">
                            <div class="form-group{{ $errors->has('avatar') ?' has-error' :'' }}" >

                                <label for="avatar" class="col-md-4 control-label">Update Profile Image</label>
                                <input id="avatar" class="col-md-6" type="file" name="avatar">
                            </div>
                        <!--pseudo name-------------------------------- -->
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Pseudo</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!--firstname-------------------------------- -->
                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label for="firstname" class="col-md-4 control-label">Nom</label>

                                <div class="col-md-6">
                                    <input id="firstname" type="text" class="form-control" name="firstname" value="{{ $user->firstName }}">

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!--lastname-------------------------------- -->
                            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label for="lastname" class="col-md-4 control-label">Prénom</label>

                                <div class="col-md-6">
                                    <input id="lastname" type="text" class="form-control" name="lastname" value="{{ $user->lastName }}">

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('lastname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!--gender-------------------------------- -->
                            <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                <label for="gender" class="col-md-4 control-label">Je suis</label>
                                <div class="col-md-6">
                                    @if($user->gender == "m")
                                    <label class="radio-inline"><input type="radio" name="gender" value="m" checked>un homme</label>
                                    <label class="radio-inline"><input type="radio" name="gender" value="f">une femme</label>
                                @else
                                        <label class="radio-inline"><input type="radio" name="gender" value="m">un homme</label>
                                        <label class="radio-inline"><input type="radio" name="gender" value="f" checked>une femme</label>

                                    @endif
                                    @if ($errors->has('gender'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!--mail-------------------------------- -->
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Email</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!--zipcode----------------------------- -->
                            <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                <label for="zipcode" class="col-md-4 control-label">Code Postal</label>

                                <div class="col-md-6">
                                    <input id="zipcode" type="text" class="form-control" name="zipcode" value="{{ $user->zipcode }}">

                                    @if ($errors->has('zipcode'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('zipcode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <!--Date de naissance birthday-------------------------------- -->
                            <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                                <label for="birthday" class="col-md-4 control-label">Date de naissance (JJ/MM/YYYY)</label>

                                <div class="col-md-6">
                                    <input id="birthday" type="date" class="form-control" name="birthday" value="{{ $user->birthday }}">

                                    @if ($errors->has('birthday'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!--Description               -------------------------------- -->
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" type="date" class="form-control" name="description" >{{ $user->description }}</textarea>

                                    @if ($errors->has('birthday'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('birthday') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Valider
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('sidebar')

    <form class="form-horizontal" id="pass" method="post" action="{{ url('/profile/edit_password') }}">

{{ csrf_field() }}
        <label for="old_password" class="col-md-12">Ancien Mot de passe</label>
        <input class="col-md-12" type="password" name="old_password">
        <label for="new_password" class="col-md-12">Nouveau Mot de passe</label>
        <input id="new_password" class="col-md-12" type="password" name="new_password">
        <label for="new_password_confirmation" class="col-md-12">Confirmer</label>
        <input class="col-md-12" id="new_password_confirmation" type="password" name="new_password_confirmation"><br />
        <button type="submit" class="btn btn-success"><i class="fa fa-lock"></i> Modifier</button>

    </form>

@endsection

