@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Add a category</h2>
        {{ Form::open(array('route' => 'admin_addCategory')) }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Add</button>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace('description');
</script>
@stop
