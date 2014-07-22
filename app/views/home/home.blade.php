@extends('layout.default')

@section('content')
<div class="box container">
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
                <div class="clearfix"></div>
            </article>
        @endforeach
    </div>
    <div class="col-md-12">
        {{ $posts->links() }}
    </div>
</div>
@stop
