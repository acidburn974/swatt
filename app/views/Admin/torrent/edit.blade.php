@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Modifier</h2>
         {{ Form::open(array('route' => array('admin_torrent_edit', 'name' => $tor->name, 'id' => $tor->id))) }}
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="name" value="{{ $tor->name }}">
                <input type="hidden" class="form-control" name="id" value="{{ $tor->id }}">
            </div>
            <button type="submit" class="btn btn-default">Save</button>
        {{ Form::close() }}
    </div>
</div>
@stop