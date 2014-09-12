<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{{ trans('common.login') }}} - {{ Config::get('other.title') }}</title>

    <!-- Meta -->
    @section('meta')
        <meta name="description" content="Login now on {{{ Config::get('other.title') }}}. Download and share torrents. Not yet member ? Signup in less than 30s.">
        <meta name="keywords" content="{{{ 'torrents, films, movies, series, tv, show, téléchargement, download, albums, logiciels, jeux, games' }}}">

        <meta property="og:title" content="{{{ Config::get('other.title') }}}">
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{ url('/img/rlm.png') }}">
        <meta property="og:url" content="{{ url('/') }}">
    @show
    <!-- /Meta -->

    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/flat-ui.css') }}">
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
</head>
<body class="login-page">
    
    <div class="container">

        <div class="col-md-4 login-logo">
            <h1>{{ Config::get('other.title') }}</h1>
        </div>
        
        @if(Session::has('message'))
        <div class="col-md-4 login-alert">
            {{ Session::pull('message') }}
        </div>
        @endif

        <div class="col-md-3 login-form">
            <h3 class="login-form-title">{{{ trans('common.login') }}}</h3>
            {{ Form::open(array('route' => 'login')) }}
                <div class="form-group">
                    <input type="text" name="username" placeholder="{{{ trans('common.username') }}}" class="form-control">
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="{{{ trans('common.password') }}}" class="form-control">
                </div>

                <button type="submit" class="btn btn-default">{{{ trans('common.login') }}}</button>
            {{ Form::close() }}
        </div>


        <div class="col-md-6 login-info">
            <p>{{{ Config::get('other.meta_description') }}}</p>
            <nav>
                <a href="{{ route('home') }}">{{{ trans('common.home') }}}</a>
                -
                <a href="{{ route('login') }}">{{{ trans('common.login') }}}</a>
                -
                <a href="{{ route('signup') }}">Inscription</a>
                -
                <a href="{{ route('reminder_get_remind') }}">{{{ trans('common.lost-password') }}}</a>
            </nav>
        </div>
    </div>

</body>
</html>