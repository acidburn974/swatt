@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Add a post</h2>
        {{ Form::open(array('route' => 'admin_article_add', 'files' => true)) }}
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title">
            </div>

            <div class="form-group">
                <label for="image">Image thumbnail</label>
                <input type="file" name="image">
            </div>

            <div class="form-group">
                <label for="content">The content of your article</label>
                <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Post</button>
        {{ Form::close() }}
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('files/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>
@stop
