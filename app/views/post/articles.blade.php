@extends('layout.default')

@section('title')
<title>Articles - {{ Config::get('other.title') }}</title>
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
    <div class="home col-md-12">
        @foreach($posts as $p)
            <article class="home-post">
                <h2 class="home-post-title"><a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}">{{{ $p->title }}}</a></h2>
                <div class="home-post-time"><time pubdate>{{ date('d M Y', strtotime($p->created_at)) }}</time></div>
                <div class="home-post-brief">
                    <p>{{{ $p->brief }}}</p>
                </div>
                <div class="home-post-more">
                    <a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}" class="btn btn-default">Read More</a>
                </div>
            </article>
            <hr>
        @endforeach
    </div>
</div>
@stop
