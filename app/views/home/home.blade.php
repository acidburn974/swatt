@extends('layout.default')

@section('content')
<div class="container">
    <div class="col-md-12 page-title">
        <h1>News</h1>
        <hr />
    </div>

    <section class="home">
        <!-- Articles -->
        @foreach($articles as $a)
            <article class="article col-md-12">
                <div class="row"> 
                    <a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}" class="article-thumb col-md-4">
                        <!-- Image -->
                        @if( ! is_null($a->image))
                            <img src="{{ url('files/img/' . $a->image) }}" class="article-thumb-img" alt="{{{ $a->title }}}">
                        @else
                            <img src="{{ url('img/missing-image.jpg') }}" class="article-thumb-img" alt="{{{ $a->title }}}">
                        @endif<!-- /Image -->
                    </a>
                    
                    <div class="col-md-8 article-title">
                        <h2><a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}">{{{ $a->title }}}</a></h2>
                    </div>

                    <div class="col-md-8 article-info">
                        <span>{{{ trans('articles.published-at') }}}</span>
                        <time datetime="{{{ date(DATE_W3C, $a->created_at->getTimestamp()) }}}">{{{ date('d M Y', $a->created_at->getTimestamp()) }}}</time>
                    </div>

                    <div class="col-md-8 article-content">
                        {{{ substr(strip_tags($a->content), 0, strpos(strip_tags($a->content), ' ', 240)) }}}...
                    </div>

                    <div class="col-md-8 article-readmore">
                        <a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}" class="btn btn-default">{{{ trans('articles.read-more') }}}</a>
                    </div>
                </div>
            </article>
        @endforeach<!-- /Articles -->
    </section>

    <div class="col-md-12 home-pagination">
        {{ $articles->links() }}
    </div>
</div>
@stop