@extends('layout.default')

@section('title')
<title>{{{ trans('common.members') }}} - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="List of users registered on {{{ Config::get('other.title') }}} with all groups. Find an user now.">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('members') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">{{{ trans('common.members') }}}</span>
	</a>
</div>
@stop


@section('content')
<div class="box container">
	<div class="members col-md-12">
		<h2>{{{ trans('common.members') }}}</h2>
		<table class="members-table table table-striped">
			<thead>
				<tr>
					<th>Image</th>
					<th>Username</th>
					<th>Group</th>
					<th>Registration date</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td>
							@if($user->image != null)
								<img src="{{ url('files/img/' . $user->image) }}" alt="{{{ $user->username }}}" class="members-table-img">
							@else
								<img src="{{ url('img/profil.png') }}" alt="{{{ $user->username }}}" class="members-table-img">
							@endif
						</td>
						<td><a href="{{ route('profil', ['username' => $user->username, 'id' => $user->id]) }}">{{{ $user->username }}}</a></td>
						<td>{{ $user->group->name }}</td>
						<td>{{ date('d M Y', strtotime($user->created_at)) }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="col-md-12">
		{{ $users->links() }}
	</div>
</div>
@stop