@extends('layout.default')

@section('title')
<title>{{{ $user->username }}} - {{{ trans('common.members') }}} - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
<meta name="description" content="The page of {{{ $user->username }}} on {{{ Config::get('other.title') }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('members') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">{{{ trans('common.members') }}}</span>
	</a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('profil', ['username' => $user->username, 'id' => $user->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">{{{ $user->username }}}</span>
	</a>
</div>
@stop


@section('content')
<div class="box container">
	<div class="profil">

		<!-- User image -->
		<div class="profil-side col-md-2">
			<h2>{{ $user->username }}</h2>
			@if($user->image != null)
				<img src="{{ url('files/img/' . $user->image) }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@else
				<img src="{{ url('img/profil.png') }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@endif
		</div><!-- /User image -->
		
		<div class="col-md-5 profil-content">
			<p>Inscrit le {{ date('d M Y', $user->created_at->getTimestamp()) }}</p>
			<p>Dernière activitée le {{ date('d M Y H:m', $user->updated_at->getTimestamp()) }}</p>
			@if( ! is_null($user->title))
				<p>Title: {{{ $user->title }}}</p>
			@endif
			@if( ! is_null($user->about))
				<p>About: {{{ $user->about }}}</p>
			@endif
			@if(Auth::check() && Auth::user()->id == $user->id)
				<p><a href="{{ route('user_edit_profil', array('username' => $user->username, 'id' => $user->id)) }}" class="btn btn-primary">Edit my profile</a></p>
			@endif
		</div>
		<div class="clearfix"></div>
	</div>
</div>
@stop
