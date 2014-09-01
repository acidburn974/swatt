@extends('layout.default')

@section('title')
<title>Torrents - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
<meta name="description" content="{{{ 'Liste des torrents disponible gratuitement et en illimité sur ' . Config::get('other.title') }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Torrents</span>
	</a>
</div>
@stop

@section('content')
<div class="container box">
    <div class="col-md-12 page-title">
        <h1 class="torrents-title">{{ trans('traduction.latest_torrents') }}</h1>
        <hr/>
    </div>

	<div class="torrents col-md-12">
		<table class="torrents-table table table-striped">
			<thead>
				<tr>
					<th>{{ trans('common.name') }}</th>
					<th><i class="fa fa-file"></i> <!-- Size --></th>
					<th><i class="fa fa-check-square-o"></i> <!-- Times completed --></th>
					<th><i class="fa fa-arrow-circle-up"></i> <!-- Seeders --></th>
					<th><i class="fa fa-arrow-circle-down"></i> <!-- Leechers --></th>
				</tr>
			</thead>
			<tbody>
				@foreach($torrents as $k => $t)
					<tr class="torrent-table-t">
						<td>
                            <ul>
                                <li>
                                    <a href="{{ route('category', array('slug' => $t->category->slug, 'id' => $t->category->id)) }}" class="torrent-table-t-category">{{ $t->category->name }}</a>
                                    <a class="view-torrent" data-id="{{ $t->id }}" data-slug="{{ $t->slug }}" href="{{ route('torrent', array('slug' => $t->slug, 'id' => $t->id)) }}">{{ $t->name }}</a>
                                </li>
                                <li><time datetime="{{ date('Y-m-d H:m:s', strtotime($t->created_at)) }}">{{{ trans('common.added_on') }}} {{ date('d M Y H:m', strtotime($t->created_at)) }}</time></li>
                            </ul>
                        </td>
						<td>{{ $t->getSize() }}</td>
						<td>{{ $t->times_completed }} {{ trans('common.times') }}</td>
						<td>{{ $t->seeders }}</td>
						<td>{{ $t->leechers }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		{{ $torrents->links() }}
	</div>
</div>
@stop