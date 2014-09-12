<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{{ trans('common.lost-password') }}} - {{{ Config::get('other.title') }}}</title>

    <!-- Meta -->
    <meta name="description" content="{{{ Config::get('other.meta_description') }}}">
    <meta name="keywords" content="{{{ 'torrents, films, movies, series, tv, show, téléchargement, download, albums, logiciels, jeux, games' }}}">

    <meta property="og:title" content="{{{ Config::get('other.title') }}}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ url('/img/rlm.png') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <!-- /Meta -->

    <link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
    
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/flat-ui.css') }}">
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">

</head>
<body class="lostpassword-page">
    
   <div class="container">
        <div class="col-md-4 lostpassword-logo">
            <h1>{{ Config::get('other.title') }}</h1>
        </div>

        @if(Session::has('message'))
        <div class="col-md-4 lostpassword-alert">
            {{ Session::pull('message') }}
        </div>
        @endif


       <div class="col-md-4 login-form lostpassword-form">
           <h3 class="lostpassword-form-title">{{{ trans('common.lost-password') }}}</h3>
           {{ Form::open(['route' => ['reminder_get_remind']]) }}
                    
               <div class="form-group">
                   <input type="text" name="email" class="form-control" placeholder="E-mail">
               </div>

               <button type="submit" class="btn btn-primary btn-block">Send</button>
           {{ Form::close() }}
       </div>
   </div>

    <div class="col-md-6 lostpassword-info">
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

</body>
</html>