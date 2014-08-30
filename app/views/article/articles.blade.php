@extends('layout.default')

@section('title')
<title>Articles - {{ Config::get('other.title') }}</title>
@stop

@section('meta')
<meta name="description" content="{{{ trans('articles.meta-articles') }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('articles') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Articles</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
    <div class="articles col-md-12">

        @foreach($articles as $a)
            <article class="articles-article">
                <div class="articles-article-title"><h1><a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}">{{{ $a->title }}}</a></h1></div>
                <div class="articles-article-date">
                    <time >{{{ date('d M Y', $a->created_at->getTimestamp())}}}</time>
                </div>

                <div class="articles-article-brief">
                    {{{ substr(strip_tags($a->content), 0, 255) }}}...
                </div>

                <div class="articles-article-more">
                    <a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}" class="btn btn-default">{{ trans('articles.read-more') }}</a>
                </div>

                <div class="clearfix"></div>
            </article>
        @endforeach

        {{ $articles->links() }}
    </div>
</div>
@stop
