@extends('layout.default')

@section('title')
<title>Articles - {{ Config::get('other.title') }}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ 'Articles and news on the tracker and the community' }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('articles') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Articles</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <div class="home col-md-12">
        @foreach($posts as $p)
            <article class="post">
                <h2 class="post-title"><a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}">{{{ $p->title }}}</a></h2>
                <div class="post-time"><time datetime="{{ date('d-m-Y h:m', strtotime($p->created_at)) }}">{{ date('d M Y', strtotime($p->created_at)) }}</time></div>
                <div class="post-brief">
                    <p>{{{ $p->brief }}}</p>
                </div>
                <div class="post-more">
                    <a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}" class="btn btn-default">Read More</a>
                </div>
                <div class="clearfix"></div>
            </article>
        @endforeach
    </div>
    <!-- Pagination -->
    <div class="col-md-12">
        {{ $posts->links() }}
    </div><!-- /Pagination -->
</div>
@stop
