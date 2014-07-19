@extends('layout.default')



@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ url('/upload') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Upload</span>
    </a>
</div>
@stop

@section('stylesheets')
<link rel="stylesheet" href="{{ url('files/wysibb/theme/default/wbbtheme.css')}}" type="text/css">
@stop

@section('content')
<div class="container">
	<div class="upload col-md-7">
		<h3 class="upload-title">Upload a torrent</h3>
		{{ Form::open(['route' => 'upload', 'files' => true, 'class' => 'upload-form']) }}

			<div class="form-group">
				<label for="name">Title</label>
				<input type="text" name="name" class="form-control">
			</div>

			<div class="form-group">
				<label for="torrent">Torrent file</label>
				<input class="upload-form-file" type="file" name="torrent">
			</div>

			<div class="form-group">
				<label for="nfo">NFO file</label>
				<input class="upload-form-file" type="file" name="nfo">
			</div>

			<div class="form-group">
				<label for="category_id">Category</label>
				<select name="category_id" class="form-control">
					@foreach($categories as $category)
						<option value="{{ $category->id }}">{{ $category->parent_cat }}: {{ $category->name }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea id="upload-form-description" name="description" cols="30" rows="10" class="form-control"></textarea>
			</div>

			<button type="submit" class="btn btn-default">Upload</button>
		{{ Form::close() }}
	</div>

	<div class="col-md-4">
		<h4>Announce URL</h4>
		<code>{{ route('announce') }}</code>
	</div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('files/wysibb/jquery.wysibb.min.js') }}"></script>
<script>
$(document).ready(function() {
    var wbbOpt = { buttons: "bold,italic,underline,|,img,link,|,code,quote" }
    $("#upload-form-description").wysibb(wbbOpt);
});
</script>
@stop
