@extends('layout.default')

@section('content')
<div class="box container">
    <div class="col-md-12">
        @foreach($posts as $p)
            <section class="post">
                <h2 class="post-title"><a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}">{{{ $p->title }}}</a></h2>
                <div class="post-time"><time datetime="{{ date('d-m-Y h:m', strtotime($p->created_at)) }}">{{ date('d M Y', strtotime($p->created_at)) }}</time></div>
                <div class="post-brief">
                    <p>{{{ $p->brief }}}</p>
                </div>
                <div class="post-more">
                    <a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}" class="btn btn-default">Read More</a>
                </div>
                <div class="clearfix"></div>
            </section>
        @endforeach
    </div>
    <div class="col-md-12">
        {{ $posts->links() }}
    </div>
</div>
@stop
