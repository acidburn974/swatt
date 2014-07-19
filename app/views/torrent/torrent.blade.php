@extends('layout.default')

@section('title')
<title>Zizitracker | {{{ $torrent->name }}}</title>
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
<div class="torrent container">
    <div class="col-md-12">
        <h1 class="torrent-title"><a href="{{ route('download', array('slug' => $torrent->slug, 'id' => $torrent->id)) }}" class="torrent-data-item">Download {{{ $torrent->name }}}</a></h1>
    </div>
    <div class="torrent-data col-md-12">
        <span class="torrent-data-item">Seeders: {{ $torrent->seeders }}</span>
        <span class="torrent-data-item">Leechers: {{ $torrent->leechers }}</span>
        <span class="torrent-data-item">Times completed: {{ $torrent->times_completed }}</span>
        <span class="torrent-data-item">Size: {{ $torrent->getSize() }}</span>
    </div>
    <div class="torrent-description col-md-12">
        <hr>
        {{ $torrent->getDescriptionHtml() }}
    </div>
    <div class="torrent-bottom col-md-12">
        <a href="{{ route('download', array('slug' => $torrent->slug, 'id' => $torrent->id)) }}" class="torrent-bottom-download btn btn-primary">Download</a>
        <hr>
        <h4>NFO</h4>
        <pre class="torrent-bottom-nfo">
            {{{ $torrent->nfo }}}
        </pre>
        <h4>Files</h4>
        <pre class="torrent-bottom-files">
            @foreach($torrent->files as $f)
                {{{ $f->name }}} <br/>
            @endforeach
        </pre>
    </div>
</div>
@stop
