@extends('layout.default')

@section('title')
<title>{{{ $topic->name }}} - Forums - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ 'Read the topic ' . $topic->name }}}">
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
            @if($topic->first_post_user_username != null && $topic->first_post_user_username != null)
                <p>Started by <a href="{{ route('profil', ['username' => $topic->first_post_user_username, 'id' => $topic->first_post_user_id]) }}">{{ $topic->first_post_user_username }}</a>, {{ date('d M Y H:m', strtotime($topic->created_at)) }}</p>
            @else
                <p>Started by {{ $topic->first_post_user_username }}, {{ date('d M Y H:m', strtotime($topic->created_at)) }}</p>
            @endif
        </div>
        <div class="topic-posts">
            <div class="topic-posts-head">
                <p>{{ $topic->num_post - 1 }} replies to this topic
                    @if(Auth::check() && (Auth::user()->group->is_modo || $p->user_id == Auth::user()->id))
                        @if($topic->state == "close")
                            <a href="{{ route('forum_open', ['slug' => $topic->slug, 'id' => $topic->id, ])}}" class="btn btn-default btn-xs"> &#128077; Open the topic</a>
                         @else
                             <a href="{{ route('forum_close', ['slug' => $topic->slug, 'id' => $topic->id, ])}}" class="btn btn-default btn-xs"> &#128077; Mark it as resolved</a>
                         @endif
                    @endif
                    </p>
            </div>
            @foreach($posts as $p)
                <div class="topic-posts-p" id="post_{{ $p->id }}">
                    <div class="topic-posts-p-info">
                        <p class="topic-posts-p-username"><a href="{{ route('profil', ['username' => $p->user->username, 'id' => $p->user->id]) }}">{{ $p->user->username }}</a></p>
                    </div>
                    <article class="topic-posts-p-content">
                        {{ $p->getContentHtml() }}
                    </article>
                    @if(Auth::check() && (Auth::user()->group->is_modo || $p->user_id == Auth::user()->id))
                        <div class="topic-moderation">
                             @if($topic->state == "close")
                                @else                     
                                 <a href="{{ route('forum_post_edit', ['slug' => $topic->slug, 'id' => $topic->id, 'postId' => $p->id]) }}" class="btn btn-default btn-xs" >Edit this post</a>
                                @endif
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>

        <div class="topic-new-post">
            <div class="topic-new-post">
            @if($topic->state == "close")
                {{ Form::open(array('route' => array('forum_reply', 'slug' => $topic->slug, 'id' => $topic->id))) }}
                    <div class="from-group">
                    <div class="col-md-12 alert alert-danger">This topic is now closed</div>
                    @else
                        <textarea name="content" id="topic-response" cols="30" rows="10"></textarea>
                    </div>
                    @if(Auth::check())
                        <button type="submit" class="btn btn-default">Post</button>
                    @else
                        <button type="submit" class="btn btn-default disabled">You must be connected</button>
                    @endif
                {{ Form::close() }}
                    @endif
            </div>
        </div>
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('topic-response');</script>
@stop
