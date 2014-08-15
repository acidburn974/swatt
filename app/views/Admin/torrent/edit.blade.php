@extends('layout.admin')

@section('stylesheets')
<link rel="stylesheet" href="{{ url('files/wysibb/theme/default/wbbtheme.css') }}">
@stop

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Edit: {{ $tor->name }}</h2>
         {{ Form::open(array('route' => array('admin_torrent_edit', 'slug' => $tor->slug, 'id' => $tor->id))) }}
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="name" value="{{ $tor->name }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="upload-form-description" name="description" cols="30" rows="10" class="form-control">{{ $tor->description }}</textarea>
            </div>
            <button type="submit" class="btn btn-default">Save</button>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('js/vendor/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('files/wysibb/jquery.wysibb.min.js') }}"></script>
<script>
$(document).ready(function() {
    var wbbOpt = {
        buttons: "bold,italic,underline,strike,sup,sub,|,img,video,link,|,bullist,numlist,|,fontcolor,fontsize,fontfamily,|, justifyleft, justifycenter,justifyright,|, quote,code,table,removeFormat"
    }
    $("#upload-form-description").wysibb(wbbOpt);
});
</script>
@stop
