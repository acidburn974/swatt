@extends('layout.admin')

@section('content')
<div class="container">
	<div class="col-md-10">
		<h2>Add a new page</h2>
        {{ Form::open(['route' => 'admin_page_add'])}}
            <div class="form-group">
                <label for="name">Page Name</label>
                <input type="text" name="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" id="content" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
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