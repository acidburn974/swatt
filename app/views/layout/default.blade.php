<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @section('title')
        <title>{{{ Config::get('other.title') }}}</title>
    @show
    @section('meta_description')
        <meta name="description" content="{{{ 'Obsessedto.me the best bittorrent community. Get exclusive access to HD movies and TV shows. The next-gen torrent tracker.' }}}">
    @show
    <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('css/main.css') }}">
    <link rel="stylesheet" href="{{ url('css/font-awesome.min.css') }}">
    <link href='http://fonts.googleapis.com/css?family=Lato|Cabin+Condensed|Open+Sans' rel='stylesheet' type='text/css'>

    @yield('stylesheets')
</head>
<body>
    <!-- header -->
    <div id="l-header">
        <div class="container">
            <header class="l-header-logo col-md-6"><h1><a href="{{ route('home') }}">{{ Config::get('other.title') }}</a></h1></header>
            <div class="l-header-user-data col-md-6">
                @if(Auth::check())
                    {{-- <a href="{{ route('profil', array('username' => Auth::user()->username, 'id' => Auth::user()->id)) }}" class="l-header-user-data-link">{{ Auth::user()->username }}</a> --}}
                    <span class="l-header-user-data-field">{{ Auth::user()->getUploaded() }} <i class="fa fa-long-arrow-up"></i></span>
                    <span class="l-header-user-data-field">{{ Auth::user()->getDownloaded() }} <i class="fa fa-long-arrow-down"></i></span>
                    <span class="l-header-user-data-field">{{ Auth::user()->getRatio() }} <i class="fa fa-arrows-v"></i></span>
                @endif
            </div>
            <nav class="l-header-menu col-md-12">
                <a href="{{ url('/') }}" class="l-header-menu-item">{{ trans('messages.home') }}</a>
                <a href="{{ route('torrents') }}" class="l-header-menu-item">Torrents</a>
                <a href="{{ route('forum_index') }}" class="l-header-menu-item">Forums</a>
                @if(Auth::check())
                    @if(Auth::user()->group->is_admin == true)
                        <a href="{{ route('admin_home') }}" class="l-header-menu-item">ACP</a>
                    @endif
                	<a href="{{ route('upload') }}" class="l-header-menu-item">Upload</a>
                    <a href="{{ route('logout') }}" class="l-header-menu-item">{{ trans('messages.logout') }}</a>
                @else
                    <a href="{{ route('login') }}" class="l-header-menu-item">{{ trans('messages.login') }}</a>
                    <a href="{{ route('signup') }}" class="l-header-menu-item">{{ trans('messages.signup') }}</a>
                @endif
            </nav>
        </div>
    </div><!-- /header -->

    <!-- breadcrumb -->
    <div id="l-breadcrumb">
    	<div class="container">
    		<div class="col-md-9">
    			<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
					<a href="{{ url('/') }}" itemprop="url" class="l-breadcrumb-item-link">
						<span itemprop="title" class="l-breadcrumb-item-link-title">Home</span>
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
            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">{{{ Config::get('other.title') }}}</h3>
                <footer>{{{ Config::get('other.title') }}} is the next-gen torrent tracker specialized in HD movies and TV shows.</footer>
            </div>

            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">Account</h3>
                <ul>
                    @if(Auth::check())
                        <li><a href="{{ route('logout') }}">Logout</a></li>
                    @else
                        <li><a href="{{ route('signup') }}">Register</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    @endif
                </ul>
            </div>

            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">Community</h3>
                <ul>
                    <li><a href="{{ route('articles') }}">News</a></li>
                    <li><a href="{{ route('forum_index') }}">Forums</a></li>
                    <li><a href="{{ route('members') }}">Members</a></li>
                </ul>
            </div>

            <div class="l-footer-section col-md-2">
                <h3 class="l-footer-section-title">Categories</h3>
                <ul>
                    @foreach(Category::all() as $category)
                        <li><a href="{{ route('category', array('slug' => $category->slug, 'id' => $category->id)) }}">{{{ $category->name }}} ({{ $category->num_torrent }})</a></li>
                    @endforeach
                </ul>
            </div>
            
        </div>
    </div><!-- /footer -->

    @yield('javascripts')
</body>
</html>
