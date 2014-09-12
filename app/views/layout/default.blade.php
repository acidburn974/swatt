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
    <!-- Header -->
    <div id="l-header">
        <div class="container">

            <!-- Logo -->
            <header class="col-md-1 l-header-logo">
                <a href="{{ route('home') }}">{{{ Config::get('other.title') }}}</a>
            </header><!-- /Logo -->

            <div class="col-md-3 l-header-search">
                {{ Form::open(array('route' => 'search')) }}

                    <div class="form-group">
                        <input type="text" name="search" placeholder="{{{ trans('common.search') }}}" class="form-control">
                    </div>
                {{ Form::close() }}
            </div>

            <nav class="col-md-5 l-header-menu">
                <a href="{{ route('home') }}" class="l-header-menu-item">Accueil</a>
                <a href="{{ route('torrents') }}" class="l-header-menu-item">Torrents</a>
                <a href="{{ route('forum_index') }}" class="l-header-menu-item">Forums</a>
                @if(!Auth::check())
                <a href="{{ route('signup') }}" class="l-header-menu-item">Inscription</a>
                <a href="{{ route('login') }}" class="l-header-menu-item">Connexion</a>
                @else
                <a href="{{ route('upload') }}" class="l-header-menu-item">Upload</a>
                @endif
            </nav>
            
            @if(Auth::check())
            <div class="col-md-3 l-header-info">
                <a href="{{ route('profil', array('username' => Auth::user()->username, 'id' => Auth::user()->id)) }}" class="l-header-user-data-link">{{ Auth::user()->username }}</a>
                <span class="l-header-info-span">{{ Auth::user()->getUploaded() }} <i class="fa fa-long-arrow-up"></i></span>
                <span class="l-header-info-span">{{ Auth::user()->getDownloaded() }} <i class="fa fa-long-arrow-down"></i></span>
                <span class="l-header-info-span">{{ Auth::user()->getRatio() }} <i class="fa fa-arrows-v"></i></span>
            </div>
            @endif
            
        </div>
    </div><!-- Header -->

    <!-- Breadcrumb -->
    <div id="l-breadcrumb">
        <div class="container">
            <div class="col-md-12">
                <div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                    <a href="{{ route('home') }}" itemprop="url" class="l-breadcrumb-item-link">
                        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ trans('common.home') }}}</span>
                    </a>
                </div>
                @yield('breadcrumb')
            </div>
        </div>
    </div><!-- Breadcrumb -->

    @if(Session::has('message'))
        <div class="container">
            <div class="col-md-12 alert alert-info">{{ Session::pull('message') }}</div>
        </div>
    @endif
    
    <div id="l-content">
        @yield('content')
    </div>
    
    <div id="l-footer">
        <div class="container">
            
            <div class="col-md-3 l-footer-section">
                <h3 class="l-footer-section-title">{{{ Config::get('other.title') }}}</h3>
                <footer>{{{ Config::get('other.meta_description') }}}</footer>
            </div>
            <!-- Compte -->
            <div class="col-md-2 l-footer-section">
                <h3 class="l-footer-section-title">{{{ trans('common.account') }}}</h3>
                <ul>
                    @if(Auth::check())
                        @if(Auth::user()->group->is_admin)
                            <li><a href="{{ route('admin_home') }}">Admin Control Panel</a></li>
                        @endif
                        <li><a href="{{ route('logout') }}">{{{ trans('common.logout') }}}</a></li>
                    @else
                        <li><a href="{{ route('login') }}">{{ trans('common.login') }}</a></li>
                        <li><a href="{{ route('signup') }}">{{ trans('common.signup') }}</a></li>
                    @endif
                </ul>
            </div><!-- /Compte -->

            <!-- Communauté -->
            <div class="col-md-2 l-footer-section">
                <h3 class="l-footer-section-title">{{{ trans('traduction.community') }}}</h3>
                <ul>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                    <li><a href="{{ route('forum_index') }}">Forums</a></li>
                    <li><a href="{{ route('members') }}">{{ trans('common.members') }}</a></li>
                    <li><a href="{{ route('articles') }}">News</a></li>
                </ul>
            </div><!-- /Communauté -->

            @if(count($pages))
            <!-- Pages -->
            <div class="col-md-3 l-footer-section">
                <h3 class="l-footer-section-title">Pages</h3>
                <ul>
                    @foreach($pages as $p)
                    <li><a href="{{ route('page', ['slug' => $p->slug, 'id' => $p->id]) }}">{{{ $p->name }}}</a></li>
                    @endforeach
                </ul>
            </div><!-- /Pages -->
            @endif
            
            {{-- 
            <!-- Other -->
            <div class="col-md-3 l-footer-section">
                <h3 class="l-footer-section-title">Other</h3>
                <ul>
                    <li><a href="http://top-tracker-fr.tk/" rel="nofollow"><img src="http://top-tracker-fr.tk/button.php?u=ralamoin" alt="Top Tracker FR" border="0"></a></li>
                    <li><p>{{{ 'Powered by swaTT' }}}</p></li>
                </ul>
            </div><!-- /Other --> --}}
        </div>
    </div>

    <!-- Scripts -->
    <script type="text/javascript">
        var url = "{{ url('/') }}";
    </script>

    <script type="text/javascript" src="{{ url('js/vendor/jquery.min.js') }}"></script>
    @yield('javascripts')<!-- /Scripts -->

	@if(Config::get('app.debug') == false)
	   <!-- INSERT YOUR ANALYTICS CODE HERE -->
    @else
        <!-- INSERT DEBUG CODE HERE -->
	@endif
</body>
</html>
