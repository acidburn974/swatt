<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    @section('title')
        <title>{{{ Config::get('other.title') }}} - Torrent Tracker</title>
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
                    <a href="{{ route('login') }}" class="l-header-menu-item">{{ trans('traduction.login') }}</a>
                    <a href="{{ route('signup') }}" class="l-header-menu-item">{{ trans('traduction.register') }}</a>
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

    
    <script type="text/javascript">
    var url = "{{ url('/') }}";
    </script>
    
    @yield('javascripts')
</body>
</html>
