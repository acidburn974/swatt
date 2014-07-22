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
@stop

@section('content')
<div class="forum container">
    <div class="col-md-12">
        <h2>Forum: {{ $forum->name }}</h2>
        @if(Auth::check())
            <a href="{{ route('forum_new_thread', array('slug' => $forum->slug, 'id' => $forum->id)) }}" class="btn btn-primary">Start a new topic</a>
        @else
            <a href="#" class="btn btn-primary disabled">You must be connected to start a new topic</a>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Topic</th>
                    <th>Response</th>
                    <th>Last post</th>
                </tr>
            </thead>
            <tbody>
                @foreach($threads as $thread)
                    <tr>
                        <td><a href="{{ route('forum_topic', array('slug' => $thread->slug, 'id' => $thread->id)) }}">{{ $thread->name }}</a></td>
                        <td>{{ $thread->num_post }}</td>
                        <td>{{ date('d M Y', strtotime($thread->updated_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
