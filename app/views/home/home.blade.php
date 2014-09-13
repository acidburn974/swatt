@extends('layout.default')

@section('content')
<div class="container home">

    <div class="col-md-12 home-newsboxes box">
        <div class="row">
            <!-- Torrents -->
            <section class="col-md-4 home-newsboxes-b">
                <h2 class="home-newsboxes-b-title"><a href="{{ route('torrents') }}">Torrents</a></h2>
                <ul>
                    @foreach($torrents as $t)
                        <li><a href="{{ route('torrent', array('slug' => $t->slug, 'id' => $t->id)) }}">{{{ $t->name }}}</a></li>
                    @endforeach
                </ul>
            </section><!-- /Torrents -->

            <!-- Topics -->
            <section class="col-md-4 home-newsboxes-b">
                <h2 class="home-newsboxes-b-title"><a href="{{ route('forum_index') }}">Forums</a></h2>
                <ul>
                    @foreach($topics as $t)
                        <li><a href="{{ route('forum_topic', array('slug' => $t->slug, 'id' => $t->id)) }}">{{{ $t->name }}}</a></li>
                    @endforeach
                </ul>
            </section><!-- /Topics -->

            <!-- Members -->
            <section class="col-md-4 home-newsboxes-b">
                <h2 class="home-newsboxes-b-title"><a href="{{ route('members') }}">{{{ trans('common.members') }}}</a></h2>
                <ul>
                    @foreach($users as $u)
                        <li><a href="{{ route('profil', array('username' => $u->username, 'id' => $u->id)) }}">{{{ $u->username }}}</a></li>
                    @endforeach
                </ul>
            </section><!-- /Members -->
        </div>
    </div>

    <div class="col-md-12 page-title">
        <h1>News</h1>
        <hr/>
    </div>

    <section>
        <!-- Articles -->
        @foreach($articles as $a)
            <article class="article col-md-12">
                <div class="row">
                    <a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}" class="article-thumb col-md-4">
                        <!-- Image -->
                        @if( ! is_null($a->image))
                            <img src="{{ url('files/img/' . $a->image) }}" class="article-thumb-img" alt="{{{ $a->title }}}">
                        @else
                            <img src="{{ url('img/missing-image.jpg') }}" class="article-thumb-img" alt="{{{ $a->title }}}">
                        @endif<!-- /Image -->
                    </a>

                    <div class="col-md-8 article-title">
                        <h2><a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}">{{{ $a->title }}}</a></h2>
                    </div>

                    <div class="col-md-8 article-info">
                        <span>{{{ trans('articles.published-at') }}}</span>
                        <time datetime="{{{ date(DATE_W3C, $a->created_at->getTimestamp()) }}}">{{{ date('d M Y', $a->created_at->getTimestamp()) }}}</time>
                    </div>

                    <div class="col-md-8 article-content">
                        {{{ substr(strip_tags($a->content), 0, strpos(strip_tags($a->content), ' ', 240)) }}}...
                    </div>

                    <div class="col-md-12 article-readmore">
                        <a href="{{ route('article', ['slug' => $a->slug, 'id' => $a->id]) }}" class="btn btn-default">{{{ trans('articles.read-more') }}}</a>
                    </div>
                </div>
            </article>
        @endforeach<!-- /Articles -->
    </section>

    <div class="col-md-12 home-pagination">
        {{ $articles->links() }}
    </div>
</div>
@stop
