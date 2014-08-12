@extends('layout.default')

@section('title')
<title>Torrents - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ 'Liste des torrents disponible gratuitement et en illimité sur' . Config::get('other.title') }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('torrents') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Torrents</span>
	</a>
</div>
@stop

@section('content')
<div class="container-fluid">
	<div class="row">

		<div class="torrents col-md-6 box left">
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
							<td><a class="view-torrent" data-id="{{ $t->id }}" data-slug="{{ $t->slug }}" href="{{ route('torrent', array('slug' => $t->slug, 'id' => $t->id)) }}">{{ $t->name }}</a></td>
							<td>{{ $t->getSize() }}</td>
							<td>{{ $t->times_completed }}</td>
							<td>{{ $t->seeders }}</td>
							<td>{{ $t->leechers }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			{{ $torrents->links() }}
		</div>

		<div class="col-md-6 right"></div>
	</div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('js/vendor/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/vendor/lodash.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/vendor/backbone.min.js') }}"></script>

<script type="text/template" id="torrent_template">
    <h1 class="torrent-title"><a href="<%= url + '/download/' + torrent.slug + '.' + torrent.id %>" class="torrent-data-item">Download <%= torrent.name %></a></h1>

    <!-- Données sur le torrent -->
    <div class="torrent-data">
        <span class="torrent-data-item">Seeders: <%= torrent.seeders %></span>
        <span class="torrent-data-item">Leechers: <%= torrent.leechers %></span>
        <span class="torrent-data-item">Times completed: <%= torrent.times_completed %></span>
        <span class="torrent-data-item">Size: <%= torrent.size %></span>
        <span class="torrent-data-item">By <a href="<%= url + '/members/' + torrent.username + '.' + torrent.user_id %>"><%= torrent.username %></a></span>
    </div><!-- Données sur le torrent -->

    <div class="torrent-description">
        <%= torrent.descriptionHtml %>
    </div>

    <div class="torrent-bottom">
    	<a href="<%= url + '/download/' + torrent.slug + '.' + torrent.id %>" class="torrent-bottom-download btn btn-primary">{{ trans('traduction.download') }}</a>
    	<a href="<%= url + '/torrents/' + torrent.slug + '.' + torrent.id %>" class="torrent-data-item btn btn-default">{{ trans('traduction.read_more') }}</a>
    </div>

    <hr />

    <form id="add-comment" data-id="<%= torrent.id %>" data-slug="<%= torrent.slug %>" method="POST" accept-charset="UTF-8">
            <div class="form-group">
                <label for="content">Your comment:</label>
                <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Save my comment</button>
    </form>

    <hr/>

    <!-- Comments -->
    <div class="comments col-md-12">
    	<% _.forEach(comments, function(comment) { %>
    		<div class="comment">
                <strong><%= comment.username %></strong> -
                <span><time pubdate><%= comment.created_at %></time></span>
                <blockquote><%= comment.content %></blockquote>
            </div>
    	<% }) %>
    </div><!-- Comments -->
</script>

<script type="text/javascript" src="{{ url('js/torrents.js') }}"></script>

@stop
