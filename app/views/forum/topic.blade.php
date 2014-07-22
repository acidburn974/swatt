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
    <a href="{{ route('forum_topic', array('slug' => $thread->slug, 'id' => $thread->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $thread->name }}</span>
    </a>
</div>
@stop

@section('content')
<div class="topic box container">

    @foreach($posts as $p)
    	<div class="topic-post col-md-12" id="forum-post-{{ $p-> id }}">
    		<article class="row">
    		    <aside class="topic-post-info col-md-2">
                    <h3>{{ $p->user->username }}</h3>
               </aside>
               <div class="topic-post-content col-md-10">
                   {{ $p->getContentHtml() }}
                   <hr>
                   <time pubdate>{{ date('d M Y', strtotime($p->created_at)) }}</time>
               </div>
           </article>
    	</div>
    @endforeach

    <div class="col-md-12">
        {{ Form::open(array('route' => array('forum_response', 'slug' => $thread->slug, 'id' => $thread->id))) }}
            <div class="form-group">
                <textarea name="response" id="topic-response" cols="30" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-default">Post</button>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('topic-response');</script>
@stop
