@extends('layout.default')

@section('title')
<title>{{{ $topic->name }}} - Forums - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
<meta name="description" content="{{{ trans('forum.read-topic') . ' ' . $topic->name }}}">
@stop

@section('stylesheets')
<link rel="stylesheet" href="{{ url('files/wysibb/theme/default/wbbtheme.css') }}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_category', array('slug' => $category->slug, 'id' => $category->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $category->name }}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_display', array('slug' => $forum->slug, 'id' => $forum->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $forum->name }}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_topic', array('slug' => $topic->slug, 'id' => $topic->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $topic->name }}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <div class="topic col-md-12">

        <h2>{{{ $topic->name }}}</h2>

        <div class="topic-info">
            <p>
                Started by <a href="{{ route('profil', ['username' => $topic->first_post_user_username, 'id' => $topic->first_post_user_id]) }}">{{ $topic->first_post_user_username }}</a>, {{ date('d M Y H:m', strtotime($topic->created_at)) }}

                @if(Auth::check() && (Auth::user()->group->is_modo || $topic->user_id == Auth::user()->id))
                    @if($topic->state == "close")
                        <a href="{{ route('forum_open', ['slug' => $topic->slug, 'id' => $topic->id, ])}}" class="btn btn-success">Open this topic</a>
                    @else
                        <a href="{{ route('forum_close', ['slug' => $topic->slug, 'id' => $topic->id, ])}}" class="btn btn-success">{{{ trans('forum.mark-as-resolved') }}}</a>
                    @endif
                @endif
                @if(Auth::check() && Auth::user()->group->is_modo)
                    <a href="{{ route('forum_delete_topic', ['slug' => $topic->slug, 'id' => $topic->id]) }}" class="btn btn-danger">{{{ trans('forum.delete-topic') }}}</a>
                @endif
            </p>

            {{ $posts->links() }}
        </div>

        <div class="topic-posts">
                <div class="topic-posts-head">
                    <p>{{ $topic->num_post - 1 }} replies to this topic</p>
                </div>

                @foreach($posts as $k => $p)
                    <div class="post" id="post_{{ $p->id }}" data-id="{{ $p->id }}">
                        <div class="col-md-12 post-head">
                            <a href="{{ route('profil', ['username' => $p->user->username, 'id' => $p->user->id]) }}" class="post-info-username">
                                {{ $p->user->username }}
                            </a>
                            <span class="post-head-date">{{ date('d/m/Y H:m:s', strtotime($p->created_at)) }}</span>
                        </div>

                        <aside class="col-md-2 post-info">

                            @if($p->user->image != null)
                                <img src="{{ url('files/img/' . $p->user->image) }}" alt="{{{ $p->user->username }}}" class="members-table-img img-thumbnail">
                            @else
                                <img src="{{ url('img/profil.png') }}" alt="{{{ $p->user->username }}}" class="members-table-img img-thumbnail">
                            @endif
                            
                            <p>{{{ $p->user->title }}}</p>
                            <p>{{ $p->user->group->name }}</p>
                            <p>{{ trans('traduction.join_date')}}: {{ date('d/m/Y', strtotime($p->user->created_at)) }}</p>
                            @if(Auth::check() && (Auth::user()->group->is_modo || $p->user_id == Auth::user()->id) && $topic->state == 'open')
                                <p><a href="{{ route('forum_post_edit', ['slug' => $topic->slug, 'id' => $topic->id, 'postId' => $p->id]) }}">Edit this post</a></p>
                            @endif

                        </aside>

                        <article class="col-md-10 post-content">
                            {{ $p->getContentHtml() }}
                        </article>

                        <div class="clearfix"></div>
                    </div>
                @endforeach

                {{ $posts->links() }}
        </div>

        <div class="topic-new-post">
            @if($topic->state == "close")
                <div class="col-md-12 alert alert-danger">This topic is closed</div>
            @else
                {{ Form::open(array('route' => array('forum_reply', 'slug' => $topic->slug, 'id' => $topic->id))) }}
                    <div class="from-group">
                        <textarea name="content" id="topic-response" cols="30" rows="10"></textarea>
                    </div>
                    @if(Auth::check())
                        <button type="submit" class="btn btn-default">{{ trans('traduction.add') }}</button>
                    @else
                        <button type="submit" class="btn btn-default disabled">You must be connected</button>
                    @endif
                {{ Form::close() }}
            @endif

            <div class="clearfix"></div>
        </div>

    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('js/vendor/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('files/wysibb/jquery.wysibb.min.js') }}"></script>
<script>
$(document).ready(function() {
    $("#topic-response").wysibb();
});
</script>
@stop
