@extends('layout.default')

@section('title')
<title>{{{ $post->title }}} - {{ Config::get('other.title') }}</title>
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('articles') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Articles</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('post', ['slug' => $post->slug, 'id' => $post->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ $post->title }}}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <article class="post col-md-12">
        <h2 class="post-title">{{{ $post->title }}}</h2>
        <div class="post-time"><time pubdate>{{ date('d M Y', strtotime($post->created_at)) }}</time></div>
        <div class="post-content">
            {{ $post->content }}
        </div>
    </article>
</div>
@stop
