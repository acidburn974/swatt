@extends('layout.default')

@section('title')
<title>Torrents - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ 'All torrents uploaded on ' . Config::get('other.title') }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Torrents</span>
	</a>
</div>
@stop

@section('content')
<div class="box container">
	<div class="torrents col-md-12">
		<h1 class="torrents-title">{{ trans('traduction.latest_torrents') }}</h1>
		<table class="torrents-list table table-striped">
			<thead>
				<tr>
					<th>Type</th>
					<th>{{ trans('traduction.title') }}</th>
					<th>{{ trans('traduction.size')}}</th>
					<th>{{ trans('traduction.times_completed') }}</th>
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
