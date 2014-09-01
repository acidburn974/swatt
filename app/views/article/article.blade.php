@extends('layout.default')

@section('title')
<title>{{{ $article->title }}} - Articles - {{ Config::get('other.title') }}</title>
@stop

@section('meta')
<meta name="description" content="{{{ substr(strip_tags($article->content), 0, 200) }}}...">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('articles') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Articles</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('article', ['slug' => $article->slug, 'id' => $article->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ $article->title }}}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <article class="article col-md-12">

        <h1 class="article-title">{{{ $article->title }}}</h1>

        <div class="article-info">
            <span>{{{ trans('articles.published-at') }}}</span>
            <time datetime="{{{ date(DATE_W3C, $article->created_at->getTimestamp()) }}}">{{{ date('d M Y', $article->created_at->getTimestamp()) }}}</time>
        </div>

        <div class="article-content">
            {{ $article->content }}
        </div>
        <hr>
    </article>

    <div class="col-md-12">
        {{ Form::open(array('route' => array('comment_article', 'slug' => $article->slug, 'id' => $article->id))) }}
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
