@extends('layout.admin')

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
<script type="text/javascript" src="{{ url('files/ckeditor_bbcode/ckeditor.js') }}"></script>
<script>CKEDITOR.replace('upload-form-description');</script>
@stop
