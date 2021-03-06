@extends('layout.default')

@section('title')
<title>{{{ $forum->name }}} - Forums - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
<meta name="description" content="{{{ trans('forum.display-forum') . $forum->name }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('forum_display', array('slug' => $forum->slug, 'id' => $forum->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $forum->name }}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <div class="f-display">
        <div class="f-display-info col-md-12">
            <h1 class="f-display-info-title">{{ $forum->name }}</h1>
            <p class="f-display-info-description">{{ $forum->description }}</p>
        </div>
        <div class="f-display-table-wrapper col-md-12">
            <table class="f-display-topics table col-md-12">
                <thead class="f-display-topics-hidden">
                    <tr>
                        <!-- <th></th> -->
                        <th>Topic</th>
                        <th>Started by</th>
                        <th>Stats</th>
                        <th>Last Post Info</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topics as $t)
                    <tr>
                        <!-- <td class="f-display-topic-icon"><img src="{{ url('img/f_icon_read.png') }}"></td> -->
                        <td class="f-display-topic-title">
                            <h4><a href="{{ route('forum_topic', array('slug' => $t->slug, 'id' => $t->id)) }}">{{{ $t->name }}}</a></h4>
                        </td>
                        <td></td>
                        <td class="f-display-topic-stats">
                            <ul>
                                <li class="f-display-topic-stats-item">{{ $t->num_post - 1 }} {{{ trans('forum.replies') }}}</li>
                                <li class="f-display-topic-stats-item">{{{ $t->views }}} {{{ trans('forum.views') }}}</li>
                            </ul>
                        </td>
                        <td class="f-display-topic-last-post">
                            <ul>
                                <li class="f-display-topic-last-post-item">
                                    <a href="{{ route('profil', ['username' => $t->last_post_user_username, 'id' => $t->last_post_user_id]) }}">{{ $t->last_post_user_username }}</a>
                                </li>
                                <li class="f-display-topic-last-post-item">
                                    <time datetime="{{ date('d-m-Y h:m', strtotime($t->updated_at)) }}">
                                        {{ date('d M Y', strtotime($t->updated_at)) }}
                                    </time>
                                </li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Permissions -->
        @if($category->getPermission()->start_topic == true)
            <a href="{{ route('forum_new_topic', array('slug' => $forum->slug, 'id' => $forum->id)) }}" class="btn btn-primary">{{ trans('traduction.start_a_new_topic') }}</a>
        @endif<!-- /Permissions -->
        <div class="f-display-pagination col-md-12">
            {{ $topics->links() }}
        </div>
    </div>
</div>
@stop
