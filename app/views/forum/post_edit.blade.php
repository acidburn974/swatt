@extends('layout.default')

@section('title')
<title>Edit post - {{{ $topic->name }}} - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ 'Edit post in ' . $forum->name }}}">
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
    <a href="{{ route('forum_topic', array('slug' => $topic->slug, 'id' => $topic->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $topic->name }}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_post_edit', array('slug' => $topic->slug, 'id' => $topic->id, 'postId' => $post->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Edit post</span>
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
		<h2>Edit a post in: {{ $forum->name }}</h2>
		{{ Form::open(array('route' => array('forum_post_edit', 'slug' => $topic->slug, 'id' => $topic->id, 'postId' => $post->id))) }}
			
			<div class="form-group">
				<textarea id="new-thread-content" name="content" cols="30" rows="10" class="form-control">{{{ $post->content }}}</textarea>
			</div>

			
			<button type="submit" name="post" value="true" class="btn btn-primary">Save</button>
			<button type="submit" name="preview" value="true" class="btn btn-default">Preview</button>
		{{ Form::close() }}
	</div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('new-thread-content');</script>
@stop
