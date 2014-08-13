<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    @section('title')
        <title>{{{ 'Téléchargement gratuit' }}} - Torrent Tracker - {{{ Config::get('other.title') }}}</title>
    @show
    @section('meta_description')
        <meta name="description" content="{{{ Config::get('other.meta_description') }}}">
    @show
    
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

                    <button type="submit" class="btn btn-default">Go !</button>
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
                    @if(Auth::user()->group->is_admin == true)
                        <a href="{{ route('admin_home') }}" class="l-header-menu-item">ACP</a>
                    @endif
                    <a href="{{ route('upload') }}" class="l-header-menu-item">Upload</a>
                    <a href="{{ route('logout') }}" class="l-header-menu-item">{{ trans('traduction.logout') }}</a>
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
            <div class="col-md-9">
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

    <!-- content -->
    <div id="l-content">
        @yield('content')
    </div><!-- /content -->

    <!-- footer -->
    <div id="l-footer">
        <div class="container">
            <div class="l-footer-section col-md-3">
                <h3 class="l-footer-section-title">{{{ Config::get('other.title') }}}</h3>
                <footer>{{{ Config::get('other.meta_description') }}}</footer>
            </div>

            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">{{ trans('traduction.account') }}</h3>
                <ul>
                    @if(Auth::check())
                        <li><a href="{{ route('logout') }}">{{ trans('traduction.logout') }}</a></li>
                    @else
                        <li><a href="{{ route('signup') }}">{{ trans('traduction.register') }}</a></li>
                        <li><a href="{{ route('login') }}">{{ trans('traduction.login') }}</a></li>
                    @endif
                </ul>
            </div>

            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">{{ trans('traduction.community') }}</h3>
                <ul>
                    <li><a href="{{ route('articles') }}">News</a></li>
                    <li><a href="{{ route('forum_index') }}">Forums</a></li>
                    <li><a href="{{ route('members') }}">{{ trans('traduction.members') }}</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">{{ trans('traduction.categories') }}</h3>
                <ul>
                    @foreach(Category::all() as $category)
                        <li><a href="{{ route('category', array('slug' => $category->slug, 'id' => $category->id)) }}">{{{ $category->name }}} ({{ $category->num_torrent }})</a></li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div><!-- /footer -->
    
    <!-- Scripts -->
    <script type="text/javascript">
        var url = "{{ url('/') }}";
    </script>
    
    <script type="text/javascript" src="{{ url('js/vendor/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/login.js') }}"></script>
    <script type="text/javascript" src="{{ url('js/signup.js') }}"></script>
    
    @yield('javascripts')
    <!-- /Scripts -->
	

	<!-- Piwik -->
	<script type="text/javascript">
	  var _paq = _paq || [];
	  _paq.push(['trackPageView']);
	  _paq.push(['enableLinkTracking']);
	  (function() {
	    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://stats.ralamoin.com/";
	    _paq.push(['setTrackerUrl', u+'piwik.php']);
	    _paq.push(['setSiteId', 1]);
	    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
	    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
	  })();
	</script>
	<noscript><p><img src="http://stats.ralamoin.com/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
	<!-- End Piwik Code -->
</body>
</html>
