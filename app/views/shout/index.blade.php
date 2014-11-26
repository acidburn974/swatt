@extends('layout.default')

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('shoutbox') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Shoutbox</span>
	</a>
</div>
@stop

@section('content')
<div class="container box">
	<div class="col-md-16 shoutbox">
		<table class="shoutbox-table table table-striped">
			<thead>
				<tr>
					<th>Username</th>
					<!-- <th>Date</th> -->
					<th>Message</th>
				</tr>
			</thead>
			<tbody class="shoutbox-shouts">
				@foreach($shouts as $s)
					<tr>
						<td>{{{ $s->user->username }}}</td>
						<!-- <td>{{ date('d M Y H:m:s', $s->created_at->getTimeStamp()) }}</td> -->
						<td>{{{ $s->content }}}</td>
					</tr>
				@endforeach
			</tbody>
		</table>


		<form action="{{ route('shoutbox_add') }}" method="POST" id="shoutbox-form" class="shoutbox-form">
			<div class="form-group">
				<input type="text" name="content" id="shout-content" class="form-control">
			</div>

			<button type="submit" class="btn btn-default">Envoyer</button>
		</form>

	</div>
</div>
@stop

@section('javascripts')
<script src="{{ url('js/shoutbox-jquery.js') }}"></script>
@stop
