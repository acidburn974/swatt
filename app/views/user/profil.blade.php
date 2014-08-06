@extends('layout.default')

@section('title')
<title>{{{ $user->username }}} - Members - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="The page of {{{ $user->username }}} on {{{ Config::get('other.title') }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('members') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Members</span>
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
		<div class="profil-image col-md-2">
			@if($user->image != null)
				<img src="{{ url('files/img/' . $user->image) }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@else
				<img src="{{ url('img/profil.png') }}" alt="{{{ $user->username }}}" class="members-table-img img-thumbnail">
			@endif
		</div>

		<div class="col-md-5">
			<h2>{{ $user->username }}</h2>
			<p>Last activity: {{ date('d M Y', strtotime($user->updated_at)) }}</p>
			<p>Registered: {{ date('d M Y', strtotime($user->created_at)) }}</p> 
			<p>Upload: {{ $user->getUploaded() }} - Download: {{ $user->getDownloaded() }}</p>
			<p>Ratio: {{ $user->getUploaded() / $user->getDownloaded() }}</p>
			<p>About :</p>
			<textarea class="form-control" name="about" rows="3" readonly="1" placeholder="{{ $user->about }}" ></textarea>
		</div>

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
		</div>
		<div class="col-md-10">
		{{ Form::open(['route' => array('user_infos','username' => $user->username, 'id' => $user->id)]) }}
		<div class="form-group">
			<label for="image">Some informations about you :</label>
				<textarea class="form-control" name="about" rows="3">{{ $user->about }}</textarea>
			</div>
		<button type="submit" class="btn btn-default">Save</button>
		{{ Form::close() }}
		</div>
			@endif

		<div class="clearfix"></div>
	</div>
</div>
@stop