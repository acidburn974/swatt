<!DOCTYPE html>
<html prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    @section('title')
        <title>{{{ Config::get('other.subTitle') }}} - {{{ Config::get('other.title') }}}</title>
    @show

    <!-- Meta -->
    @section('meta')
        <meta name="description" content="{{{ Config::get('other.meta_description') }}}">
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
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">

    @yield('stylesheets')
</head>
<body>
    @if( ! Auth::check())
    <!-- Top login -->
    <div id="l-toplogin">
        <div class="container">
            <div class="col-md-4 centered-form">
                {{ Form::open(array('route' => 'login')) }}
                    <p>{{{ trans('common.login') }}}</p>
                    <div class="form-group">
                        <label class="l-header-menu-item" for="username">{{ trans('common.username') }}</label>
                        <input name="username" type="text"  class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="l-header-menu-item" for="password">{{ trans('common.password') }}</label>
                        <input name="password" type="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">{{{ trans('common.login') }}}</button>
                {{ Form::close() }}
            </div>
        </div>
    </div><!-- /Top login -->
    <!-- Top Signup -->
    <div id="l-topsignup">
        <div class="container">
            <div class="col-md-4  centered-form">
                <p>{{{ trans('common.signup') }}}</p>
                {{ Form::open(array('route' => 'signup')) }}
                    <div class="form-group">
                        <label for="username">{{{ trans('common.username') }}}</label>
                        <input type="text" name="username" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">{{{ trans('common.password') }}}</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-default">Let's go !</button>
                {{ Form::close() }}
            </div>
        </div>
    </div> <!-- /Top Signup -->
    @endif

    <!-- header -->
    <div id="l-header">
        <div class="container">
            <!-- Logo -->
            <header class="l-header-logo col-md-3 animated pulse">
                <h1><a href="{{ route('home') }}">{{ Config::get('other.title') }}</a></h1>
            </header><!-- /Logo -->

            <div class="l-header-search col-md-3">
                {{ Form::open(array('url' => '/search')) }}
                    <input type="text" id="search-input" name="search" class="form-control" placeholder="{{{ trans('traduction.search') }}}">
                {{ Form::close() }}
            </div>

            <!-- Menu -->
            <div class="l-header-user-data col-md-6">
                @if(Auth::check())
                    <a href="{{ route('profil', array('username' => Auth::user()->username, 'id' => Auth::user()->id)) }}" class="l-header-user-data-link">{{ Auth::user()->username }}</a>
                    <span class="l-header-user-data-field">{{ Auth::user()->getUploaded() }} <i class="fa fa-long-arrow-up"></i></span>
                    <span class="l-header-user-data-field">{{ Auth::user()->getDownloaded() }} <i class="fa fa-long-arrow-down"></i></span>
                    <span class="l-header-user-data-field">{{ Auth::user()->getRatio() }} <i class="fa fa-arrows-v"></i></span>
                @endif
            </div><!-- /Menu -->

            <!-- Bar de navigation -->
            <nav class="l-header-menu col-md-12">
                <a href="{{ url('/') }}" class="l-header-menu-item">{{ trans('traduction.home') }}</a>
                <a href="{{ route('torrents') }}" class="l-header-menu-item">Torrents</a>
                <a href="{{ route('forum_index') }}" class="l-header-menu-item">Forums</a>
                @if(Auth::check())
                    <a href="{{ route('upload') }}" class="l-header-menu-item">Upload</a>
                    <!-- <a href="{{ route('logout') }}" class="l-header-menu-item">{{ trans('traduction.logout') }}</a> -->
                @else
                     <a href="{{ route('login') }}" class="l-header-menu-item" id="header-login">{{ trans('traduction.login') }}</a>
                     <a href="{{ route('signup') }}" class="l-header-menu-item" id="header-signup">{{ trans('traduction.signup') }}</a>
                @endif
            </nav><!-- Bar de navigation -->
        </div>
    </div><!-- /header -->

    <!-- breadcrumb -->
    <div id="l-breadcrumb">
        <div class="container">
            <div class="col-md-12">
                <div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a href="{{ url('/') }}" itemprop="url" class="l-breadcrumb-item-link">
                        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('traduction.home') }}</span>
                    </a>
                </div>
                @yield('breadcrumb')
            </div>
        </div>
    </div><!-- /breadcrumb -->

    @if(Session::has('message'))
    <!-- flash -->
    <div id="l-flash">
        <div class="container">
            <div class="col-md-12 alert alert-success">{{ Session::pull('message') }}</div>
        </div>
    </div><!-- /flash -->
    @endif

    @if(Session::has('status'))
    <!-- Status -->
    <div id="l-flash">
        <div class="container">
            <div class="col-md-12 alert alert-success">{{ Session::pull('status') }}</div>
        </div>
    </div><!-- Status -->
    @endif


    @if(Session::has('error'))
    <!-- Error -->
    <div id="l-flash">
        <div class="container">
            <div class="col-md-12 alert alert-danger">{{ Session::pull('error') }}</div>
        </div>
    </div><!-- /Error -->
    @endif

    <!-- content -->
    <div id="l-content">
        @yield('content')
    </div><!-- /content -->

    <div id="l-prefooter">
        <div class="container">
            <!-- Compte -->
            <div class="l-prefooter-section col-md-2">
                <h3 class="l-prefooter-section-title">{{ trans('traduction.account') }}</h3>
                <ul>
                    @if(Auth::check())
                        <li><a href="{{ route('profil', ['username' => Auth::user()->username, 'id' => Auth::user()->id]) }}">{{ Auth::user()->username }}</a></li>
                        @if(Auth::user()->group->is_admin == true)
                            <a href="{{ route('admin_home') }}">Admin Control Panel</a>
                        @endif
                        <li><a href="{{ route('logout') }}">{{ trans('traduction.logout') }}</a></li>
                    @else
                        <li><a href="{{ route('signup') }}">{{ trans('traduction.register') }}</a></li>
                        <li><a href="{{ route('login') }}">{{ trans('traduction.login') }}</a></li>
                        <li><a href="{{ route('reminder_get_remind') }}">{{ trans('common.lost-password') }}</a></li>
                    @endif
                </ul>
            </div><!-- /Compte -->

            <!-- Communauté -->
            <div class="l-prefooter-section col-md-2">
                <h3 class="l-prefooter-section-title">{{ trans('traduction.community') }}</h3>
                <ul>
                    <li><a href="{{ route('articles') }}">News</a></li>
                    <li><a href="{{ route('forum_index') }}">Forums</a></li>
                    <li><a href="{{ route('members') }}">{{ trans('traduction.members') }}</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div><!-- /Communauté -->

            <!-- Categories -->
            <div class="l-prefooter-section col-md-2">
                <h3 class="l-prefooter-section-title">{{ trans('traduction.categories') }}</h3>
                <ul>
                    @foreach(Category::all() as $category)
                        <li><a href="{{ route('category', array('slug' => $category->slug, 'id' => $category->id)) }}">{{{ $category->name }}} ({{ $category->num_torrent }})</a></li>
                    @endforeach
                </ul>
            </div><!-- /Categories -->

            <!-- Page -->
            @if(isset($pages) && $pages->isEmpty() == false)
            <div class="l-prefooter-section col-md-2">
                <h3 class="l-prefooter-section-title">Pages</h3>
                <ul>
                    @foreach($pages as $page)
                        <li><a href="{{ route('page', ['slug' => $page->slug, 'id' => $page->id]) }}">{{ $page->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif<!-- /Page -->
        </div>
    </div>

    <!-- footer -->
    <div id="l-footer">
        <div class="container">
            <!-- Info tracker -->
            <div class="l-footer-section col-md-12">
                <h3 class="l-footer-section-title">{{{ Config::get('other.title') }}}</h3>
                <footer><p>{{{ Config::get('other.meta_description') }}}</p></footer>
            </div><!-- /Info tracker -->
        </div>
    </div><!-- /footer -->

    <!-- Scripts -->
    <script type="text/javascript">
        var url = "{{ url('/') }}";
    </script>

    <script type="text/javascript" src="{{ url('js/vendor/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/login.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/signup.js') }}"></script>
    @yield('javascripts')<!-- /Scripts -->


	@if(Config::get('app.debug') == false)
	   <!-- INSERT YOUR ANALYTICS CODE HERE -->
    @else
        <!-- INSERT DEBUG CODE HERE -->
	@endif
</body>
</html>
