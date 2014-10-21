@extends('layout.default')

@section('title')
<title>Forums - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
<meta name="description" content="{{{ 'Forum de partage et d\'échange de ' . Config::get('other.title') . '. Téléchargez vos films et séries préférer en torrent. Rejoignez la communauté.' }}}">
@stop


@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
	</a>
</div>
@stop

@section('content')
<div class="box container">
	<div class="forum-categories">
		@foreach($categories as $category)
			@if($category->getPermission() != null && $category->getPermission()->show_forum == true && $category->getForumsInCategory()->count() > 0)
			<div class="forum-category">
				<div class="forum-category-title col-md-12">
					<h1>{{{ $category->name }}}</h1>
					<hr/>
				</div>

				<div class="forum-category-childs">
					@foreach($category->getForumsInCategory() as $categoryChild)
						<a href="{{ route('forum_display', ['slug' => $categoryChild->slug, 'id' => $categoryChild->id]) }}" class="forum-category-childs-forum col-md-4">
							<h2>{{{ $categoryChild->name }}}</h2>
							<p>{{{ $categoryChild->description }}}</p>
						</a>
					@endforeach
				</div>
			</div>
			@endif
		@endforeach
	</div>
</div>
@stop


@section('javascripts')
<!-- <script type="text/javascript" src="{{ url('js/vendor/lodash.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/vendor/backbone.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/vendor/handlebars.js') }}"></script>
<script type="text/javascript" src="{{ url('js/forum.js') }}"></script> -->
@stop
