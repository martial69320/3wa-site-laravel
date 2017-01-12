<!-- ressources/views/advert/list.blade.php-->
@extends('layouts.app')

@section('content')
    <h1>{{ $mainTitle }}</h1>
    @foreach($users as $user)
        <div class="row">
            <div class="col-md-4"><img src="uploads/avatars/{{ $user->id }}/{{ $user->avatar }}" width="150px"></div>
            <div class="col-md-8 well well-lg">
        <h2><a href="user/{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</a></h2>
        {{ $user->description }}<br />
                <hr/>
                {{ $user->created_at->format('d-m-Y') }} | {{ $user->age }} ans | {{ $user->city }} @if(!Auth::user())
                    "Veuillez vous connecter afin de connaitre la distance"
                @else
                    - {{ $user->distance }} km @endif <br />
            </div>
        </div>
    @endforeach

    {{  $users->links() }}
@endsection