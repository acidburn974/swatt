@extends('layout.default')

@section('title')
<title>{{{ $category->name }}} - Category - {{ Config::get('other.title') }}</title>
@stop

@section('meta')
<meta name="description" content="{{{ 'Découvrez tout les torrents dans la catégorie ' . $category->name  . ' disponible en téléchargement gratuit' }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('categories') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Categories</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('category', array('slug' => $category->slug, 'id' => $category->slug)) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ $category->name }}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <div class="torrents col-md-12">
        <h1 class="torrents-title">Torrents in {{ $category->name }}</h1>
        <table class="torrents-list table table-striped">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Size</th>
                    <th>Times completed</th>
                    <th>Seeders</th>
                    <th>Leechers</th>
                </tr>
            </thead>
            <tbody>
                @foreach($torrents as $k => $t)
                    <tr>
                        <td><a href="{{ route('category', array('slug' => $t->category->slug, 'id' => $t->category->id)) }}">{{ $t->category->name }}</a></td>
                        <td><a href="{{ route('torrent', array('slug' => $t->slug, 'id' => $t->id)) }}">{{ $t->name }}</a></td>
                        <td>{{ $t->getSize() }}</td>
                        <td>{{ $t->times_completed }}</td>
                        <td>{{ $t->seeders }}</td>
                        <td>{{ $t->leechers }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
