@extends('layout.default')

@section('title')
<title>{{{ $post->title }}} - Articles - {{ Config::get('other.title') }}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ substr(strip_tags($post->content), 0, 200) }}}...">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('articles') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Articles</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('article', ['slug' => $post->slug, 'id' => $post->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ $post->title }}}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <article class="post col-md-12">
        <h2 class="post-title">{{{ $post->title }}}</h2>
        <div class="post-time"><time datetime="{{ date('d-m-Y h:m', strtotime($post->created_at)) }}">{{ date('d M Y', strtotime($post->created_at)) }}</time></div>
        <div class="post-content">
            {{ $post->content }}
        </div>
        <hr>
    </article>

    <div class="col-md-12">
        {{ Form::open(array('route' => array('comment_article', 'slug' => $post->slug, 'id' => $post->id))) }}
            <div class="form-group">
                <label for="content">Your comment:</label>
                <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Save my comment</button>
        {{ Form::close() }}
        <hr>
    </div>

    <div class="comments col-md-12">
        @foreach($comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->username }}</strong> -
                <span><time pubdate>{{ date('d M Y h:m', strtotime($comment->created_at)) }}</time></span>
                <blockquote>{{{ $comment->content }}}</blockquote>
            </div>
        @endforeach
    </div>
</div>
@stop
