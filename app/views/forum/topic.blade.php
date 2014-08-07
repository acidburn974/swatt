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
            <p>Started by <a href="{{ route('profil', ['username' => $topic->first_post_user_username, 'id' => $topic->first_post_user_id]) }}">{{ $topic->first_post_user_username }}</a>, {{ date('d M Y H:m', strtotime($topic->created_at)) }}</p>

            {{ $posts->links() }}
        </div>

        <div class="topic-posts">
            <div class="topic-posts-head">
                <p>{{ $topic->num_post - 1 }} replies to this topic</p>
            </div>

            @foreach($posts as $p)
                <div class="post" id="post_{{ $p->id }}">
                    <aside class="col-md-2 post-info">
                        <a href="{{ route('profil', ['username' => $p->user->username, 'id' => $p->user->id]) }}" class="post-info-username">
                            {{ $p->user->username }}
                        </a>
                        @if($p->user->image != null)
                            <img src="{{ url('files/img/' . $p->user->image) }}" alt="{{{ $p->user->username }}}" class="members-table-img img-thumbnail">
                        @else
                            <img src="{{ url('img/profil.png') }}" alt="{{{ $p->user->username }}}" class="members-table-img img-thumbnail">
                        @endif

                        <p>{{ $p->user->group->name }}</p>
                    </aside>

                    <article class="col-md-10 post-content">
                        {{ $p->getContentHtml() }}
                    </article>

                    <div class="col-md-10 post-control">
                        @if(Auth::check() && (Auth::user()->group->is_modo || $p->user_id == Auth::user()->id))
                            <a href="{{ route('forum_post_edit', ['slug' => $topic->slug, 'id' => $topic->id, 'postId' => $p->id]) }}">Edit</a>
                        @endif
                    </div>

                    <div class="clearfix"></div>
                </div>
            @endforeach

            {{ $posts->links() }}
        </div>

        <div class="topic-new-post">
            {{ Form::open(array('route' => array('forum_reply', 'slug' => $topic->slug, 'id' => $topic->id))) }}
                <div class="from-group">
                    <textarea name="content" id="topic-response" cols="30" rows="10"></textarea>
                </div>
                @if(Auth::check())
                    <button type="submit" class="btn btn-default">Post</button>
                @else
                    <button type="submit" class="btn btn-default disabled">You must be connected</button>
                @endif
            {{ Form::close() }}
        </div>
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('topic-response');</script>
@stop
