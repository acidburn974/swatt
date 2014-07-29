@extends('layout.default')

@section('title')
<title>{{{ $forum->name }}} - Forums - {{{ Config::get('other.title') }}}</title>
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
@stop

@section('content')
<div class="box container">
    <div class="f-display">
        <div class="f-display-info col-md-12">
            <h2 class="f-display-info-title">{{ $forum->name }}</h2>
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
                                <li class="f-display-topic-stats-item"><strong>{{ $t->num_post - 1 }}</strong> replies</li>
                                <li class="f-display-topic-stats-item"><strong>{{{ $t->views }}}</strong> views</li>
                            </ul>
                        </td>
                        <td class="f-display-topic-last-post">
                            <ul>
                                <li class="f-display-topic-last-post-item">
                                    @if($t->last_post_user_username != null && $t->last_post_user_id != null)
                                        <a href="{{ route('profil', ['username' => $t->last_post_user_username, 'id' => $t->last_post_user_id]) }}">{{ $t->last_post_user_username }}</a>
                                    @else
                                        {{ $t->last_post_user_username }}
                                    @endif
                                </li>
                                <li class="f-display-topic-last-post-item"><time pubdate>{{ date('d M Y', strtotime($t->updated_at)) }}</time></li>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Permissions -->
        @if($category->getPermission()->start_topic == true)
            <a href="{{ route('forum_new_topic', array('slug' => $forum->slug, 'id' => $forum->id)) }}" class="btn btn-primary">Start a new topic</a>
        @endif<!-- /Permissions -->
        <div class="f-display-pagination col-md-12">
            {{ $topics->links() }}
        </div>
    </div>
</div>
@stop
