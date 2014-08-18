@extends('layout.default')


@section('content')
<div class="container">
    <div class="home col-md-12">
        
        @foreach($articles as $a)
            <article class="home-article">
                <div class="home-article-title"><h1><a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}">{{{ $a->title }}}</a></h1></div>
                <div class="home-article-date">
                    <time >{{{ date('d M Y', $a->created_at->getTimestamp())}}}</time>
                </div>

                <div class="home-article-brief">
                    {{{ substr(strip_tags($a->content), 0, 255) }}}...
                </div>

                <div class="home-article-more">
                    <a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}" class="btn btn-default">{{ trans('traduction.read_more') }}</a>
                </div>

                <div class="clearfix"></div>
            </article>
        @endforeach
        
        {{ $articles->links() }}
    </div>
</div>
@stop