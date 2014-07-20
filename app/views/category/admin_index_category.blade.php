@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Categories</h2>
        <a href="{{ route('admin_addCategory') }}" class="btn btn-primary">Add a category</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $c)
                    <tr>
                        <td><a href="{{ route('admin_editCategory', array('slug' => $c->slug, 'id' => $c->id)) }}">{{ $c->name }}</a></td>
                        <td><a href="{{ route('admin_deleteCategory', array('slug' => $c->slug, 'id' => $c->id)) }}" class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@stop
