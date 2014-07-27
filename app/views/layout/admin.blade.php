<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - {{ Config::get('other.title') }}</title>
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">

    @yield('stylesheets')
</head>
<body>

    <div class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-collapse collapse">
                <a class="navbar-brand" href="#">{{ Config::get('other.title') }}</a>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ route('admin_home') }}">Dashboard</a></li>
                    <li><a href="{{ route('home') }}">Front End</a></li>
                </ul>
            </div>
        </div>
    </div>

    @if(Session::has('message'))
    <!-- flash -->
    <div id="l-flash">
        <div class="container">
            <div class="col-md-12 alert alert-success">{{ Session::pull('message') }}</div>
        </div>
    </div><!-- /flash -->
    @endif

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li><a href="{{ route('admin_home') }}">Overview</a></li>
                    <li><a href="{{ route('admin_article_index') }}">Articles</a></li>
                    <li><a href="{{ route('admin_category_index') }}">Categories</a></li>
                    <li><a href="{{ route('admin_forum_index') }}">Forums</a></li>
                </ul>
            </div>

            @yield('content')
        </div>
    </div>


    @yield('javascripts')
</body>
</html>
