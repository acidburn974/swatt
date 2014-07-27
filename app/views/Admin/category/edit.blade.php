@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Edit a category</h2>
        {{ Form::open(array('route' => array('admin_category_edit', 'slug' => $category->slug, 'id' => $category->id))) }}
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $category->name }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ $category->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
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
