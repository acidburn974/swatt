@extends('layout.default')

@section('title')
<title>Create a new topic - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta type="description" content="{{{ 'Create a new topic in ' . $forum->name }}}">
@stop

@section('stylesheets')
<link rel="stylesheet" href="{{ url('files/wysibb/theme/default/wbbtheme.css')}}" type="text/css">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_category', array('slug' => $category->slug, 'id' => $category->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $category->name }}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_display', array('slug' => $forum->slug, 'id' => $forum->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $forum->name }}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_new_topic', array('slug' => $forum->slug, 'id' => $forum->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">New Thread</span>
    </a>
</div>
@stop

@section('content')
<div class="forum box container">
	@if(isset($parsedContent))
		<div class="preview col-md-12">
			{{ $parsedContent }}
		</div><hr>
	@endif

	<div class="col-md-12">
		<h2>Start a new topic in {{ $forum->name }}</h2>
		{{ Form::open(array('route' => array('forum_new_topic', 'slug' => $forum->slug, 'id' => $forum->id))) }}
			<div class="form-group">
				<input type="text" name="title" class="form-control" placeholder="Title of the discussion" value="{{ $title }}">
			</div>
			
			<div class="form-group">
				<textarea id="new-thread-content" name="content" cols="30" rows="10" class="form-control">{{ $content }}</textarea>
			</div>

			
			<button type="submit" name="post" value="true" class="btn btn-primary">Send this new subject</button>
			<button type="submit" name="preview" value="true" class="btn btn-default">Preview</button>
		{{ Form::close() }}
	</div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('new-thread-content');</script>
@stop
