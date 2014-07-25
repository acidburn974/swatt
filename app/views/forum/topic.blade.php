@extends('layout.default')

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
            <p>Started by {{{ $topic->first_post_user_username }}}, {{ date('d M Y H:m', strtotime($topic->created_at)) }}</p>
        </div>
        <div class="topic-posts">
            <div class="topic-posts-head">
                <p>{{ $topic->num_post - 1 }} replies to this topic</p>
            </div>
            @foreach($posts as $p)
                <div class="topic-posts-p" id="post_{{ $p->id }}">
                    <div class="topic-posts-p-info">
                        <p class="topic-posts-p-username">{{{ $p->user->username }}}</p>
                    </div>
                    <article class="topic-posts-p-content">
                        {{ $p->getContentHtml() }}
                    </article>
                </div>
            @endforeach
            <div class="clearfix"></div>
        </div>

        <div class="topic-new-post">
            <div class="topic-new-post">
                {{ Form::open(array('route' => array('forum_reply', 'slug' => $topic->slug, 'id' => $topic->id))) }}
                    <div class="from-group">
                        <textarea name="content" id="topic-response" cols="30" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Post</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('topic-response');</script>
@stop
