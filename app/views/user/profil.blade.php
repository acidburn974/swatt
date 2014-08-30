@extends('layout.default')

@section('title')
<title>{{{ $user->username }}} - Members - {{{ Config::get('other.title') }}}</title>
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
		<div class="profil-image col-md-2">
			@if($user->image != null)
				<img src="{{ url('files/img/' . $user->image) }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@else
				<img src="{{ url('img/profil.png') }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@endif
		</div><!-- /User image -->
		<!-- User data -->
		<div class="col-md-5">
			<h2>{{ $user->username }}</h2>
			<p>Last activity: {{ date('d M Y', strtotime($user->updated_at)) }}</p>
			<p>Registered: {{ date('d M Y', strtotime($user->created_at)) }}</p>
			<p>Upload: {{ $user->getUploaded() }} - Download: {{ $user->getDownloaded() }}</p>
			<p>Ratio: {{ $user->getUploaded() / $user->getDownloaded() }}</p>
			@if($user->about)
				<p>About : <blockquote>{{{ $user->about }}}</blockquote></p>
			@endif
		</div><!-- /User data -->

		<!-- User image form -->
		<div class="col-md-5">
			@if(Auth::check() && Auth::user()->id == $user->id)
				<h3>Change your image:</h3>
				{{ Form::open(['route' => array('user_change_photo', 'username' => $user->username, 'id' => $user->id), 'files' => true]) }}
					<div class="form-group">
						<label for="image">Image</label>
						<input type="file" name="image">
					</div>
					<button type="submit" class="btn btn-default">Save</button>
				{{ Form::close() }}
			@endif
		</div><!-- /User image form -->

		<!-- User about form -->
		<div class="col-md-10">
		@if(Auth::check() && Auth::user()->id == $user->id)
			{{ Form::open(['route' => array('user_change_about', 'username' => $user->username, 'id' => $user->id)]) }}
			<div class="form-group">
				<label for="image">Some informations about you :</label>
					<textarea class="form-control" name="about" rows="3">{{ $user->about }}</textarea>
				</div>
			<button type="submit" class="btn btn-default">Save</button>
			{{ Form::close() }}
		@endif
	</div><!-- /User about form -->


		<div class="clearfix"></div>
	</div>
</div>
@stop
