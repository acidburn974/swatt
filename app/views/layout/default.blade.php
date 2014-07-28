<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    @section('title')
        <title>{{{ Config::get('other.title') }}}</title>
    @show
    @section('meta_description')
        <meta type="description" content="{{{ 'Torrent tracker specialized in high qualities movies and tv series' }}}">
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
            <div class="l-header-logo col-md-6"><h1><a href="{{ route('home') }}">{{ Config::get('other.title') }}</a></h1></div>
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
            <div class="col-md-4">
                <h3>{{{ Config::get('other.title') }}}</h3>
                <p>A new sort of torrent tracker specialized in HD movies and tv series.</p>
                {{-- <p>Page generated in {{ round((microtime(TRUE)-$_SERVER['REQUEST_TIME_FLOAT']), 4) . 's' }}</p> --}}
            </div>
            <div class="col-md-4">
                <h3>Categories</h3>
                @foreach(Category::all() as $category)
                <a href="{{ route('category', array('slug' => $category->slug, 'id' => $category->id)) }}">
                    {{{ $category->name }}} ({{ $category->num_torrent }})
                </a><br>
                @endforeach
            </div>
        </div>
    </div><!-- /footer -->

    @yield('javascripts')
</body>
</html>
