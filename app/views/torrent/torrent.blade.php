@extends('layout.default')

@section('title')
    <title>{{{ $torrent->name }}} - Torrents - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
    <meta name="description" content="{{{ 'Télécharger ' . $torrent->name . ' en illimité à la vitesse maximum' }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Torrents</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('torrent', ['slug' => $torrent->slug, 'id' => $torrent->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">{{{ $torrent->name }}}</span>
	</a>
</div>
@stop

@section('content')
<div class="torrent box container">
    <div class="col-md-12">
        <h1 class="torrent-title"><a href="{{ route('download', array('slug' => $torrent->slug, 'id' => $torrent->id)) }}" class="torrent-data-item">{{{ $torrent->name }}}</a></h1>
    </div>

    <!-- Données sur le torrent -->
    <div class="torrent-data col-md-12">
        <span class="torrent-data-item">Seeders: {{ $torrent->seeders }}</span>
        <span class="torrent-data-item">Leechers: {{ $torrent->leechers }}</span>
        <span class="torrent-data-item">Times completed: {{ $torrent->times_completed }}</span>
        <span class="torrent-data-item">Size: {{ $torrent->getSize() }}</span>
        <span class="torrent-data-item">By <a href="{{ route('profil', ['username' => $user->username, 'id' => $user->id]) }}">{{ $user->username }}</a></span>
    </div><!-- Données sur le torrent -->


    <div class="torrent-description col-md-12">
        <hr>
        {{ $torrent->getDescriptionHtml() }}
    </div>
    <div class="torrent-bottom col-md-12">
        <a href="{{ route('download', array('slug' => $torrent->slug, 'id' => $torrent->id)) }}" class="torrent-bottom-download btn btn-primary">{{{ trans('common.download') }}}</a>
        <hr>
        @if($torrent->nfo != null)
            <h4>NFO</h4>
            <pre class="torrent-bottom-nfo">
                {{{ $torrent->nfo }}}
            </pre>
        @endif

        <h4>Files</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('traduction.name') }}</th>
                    <th>{{ trans('traduction.size') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($torrent->files as $k => $f)
                    <tr>
                        <td>{{ $k + 1 }}</td>
                        <td>{{ $f->name }}</td>
                        <td>{{ $f->getSize() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Add comment -->
    <div class="col-md-12">
        {{ Form::open(array('route' => array('comment_torrent', 'slug' => $torrent->slug, 'id' => $torrent->id))) }}
            <div class="form-group">
                <label for="content">Your comment:</label>
                <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">{{ trans('traduction.save') }}</button>
        {{ Form::close() }}
        <hr>
    </div><!-- Add comment -->
    
    <!-- Comments -->
    <div class="comments col-md-12">
        @foreach($comments as $comment)
            <div class="comment">
                <strong>{{ $comment->user->username }}</strong> -
                <span><time pubdate>{{ date('d M Y h:m', strtotime($comment->created_at)) }}</time></span>
                <blockquote>{{{ $comment->content }}}</blockquote>
            </div>
        @endforeach
    </div><!-- Comments -->
</div>
@stop
