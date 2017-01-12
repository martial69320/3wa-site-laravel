<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link type="text/css" rel="stylesheet" href="{{asset('assets/style.css')}}"/>
    <style>


        body {
            font-family: 'Lato';



        }

        .fa-btn {
            margin-right: 6px;
        }
        .navbar-nav li a {
            color:#B43104;
        }


    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-dark bg-success navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
            <!--<a class="navbar-brand" href="{{ url('/') }}">
                    Laravel
                </a>-->
                <img src="{{asset('assets/ol.png')}}" height="60"/>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">ACCUEIL</a></li>
                    <li><a href="{{ url('/adverts') }}">ANNONCES</a></li>
                    <li><a href="{{ url('/users') }}">MEMBRES</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/profile') }}"><i class="fa fa-btn fa-user"></i>Profile</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success')) <!-- On affiche le contenu de notre session flash success si elle existe -->

    <div class="alert alert-success">

    {{ session('success') }}
    <!-- une fois affichée cette session détruite -->

    </div>
    @endif


    @if(count($errors) != 0)

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)

                -{{ $error }} <br>

            @endforeach



        </div>

    @endif


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @yield('sidebar')
                    </div>
                </div>
            </div>
            <div class="col-md-6 offset-md-2">

                @yield('content')
                    </div>
            </div>
        </div>
    </div>



    <footer>
        <nav class="navbar navbar-dark bg-success">
            <div class="container">
            <div class="row">
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav navbar-right bg-success">
                    <li><a href="#">CGU</a></li>
                    <li><a href="#">CGV</a></li>
                    <li><a href="#">CONTACT</a></li>
                </ul>
            </div>
            </div>
        </div>
    </footer>
       <!-- JavaScripts -->
       <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
       {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
