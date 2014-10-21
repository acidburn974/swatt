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

		<!-- User image and edition -->
		<div class="profil-side col-md-2">
			<h2>{{ $user->username }}</h2>
			@if($user->image != null)
				<img src="{{ url('files/img/' . $user->image) }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@else
				<img src="{{ url('img/profil.png') }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@endif

			@if(Auth::check() && Auth::user()->id == $user->id)
			<p><a href="{{ route('user_edit_profil', ['username' => $user->username, 'id' => $user->id]) }}" class="btn btn-primary btn-block">Editer mon profil</a></p>
			<p><a href="{{ route('user_invite') }}" class="btn btn-primary btn-block">Inviter quelqu'un</a></p>
			@endif
		</div><!-- /User image and edition -->

		<div class="col-md-5 profil-content">
			<p>Inscrit le {{ date('d M Y', $user->created_at->getTimestamp()) }}</p>
			<p>Dernière activitée le {{ date('d M Y H:m', $user->updated_at->getTimestamp()) }}</p>
			@if( !is_null($user->title))
				<p>Titre: {{{ $user->title }}}</p>
			@endif
			@if( !is_null($user->about))
				<p>A propos: {{{ $user->about }}}</p>
			@endif
			@if( !is_null($user->signature))
				<p>Signature: {{ $user->getSignature() }}</p>
			@endif
		</div>
		<div class="clearfix"></div>
	</div>
</div>
@stop
