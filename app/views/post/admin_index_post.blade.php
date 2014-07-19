@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>Articles</h2>
        <a href="{{ route('admin_addPost') }}" class="btn btn-primary">Add a post</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Comments</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $p)
                    <tr>
                        <td><a href="{{ route('admin_editPost', array('slug' => $p->slug, 'id' => $p->id)) }}">{{ $p->title }}</a></td>
                        <td><a href="{{ route('admin_editUser', array('username' => $p->user->username, 'id' => $p->user->id)) }}">{{ $p->user->username }}</a></td>
                        <td>0</td>
                        <th>{{ date('d/m/Y', strtotime($p->created_at)) }}</th>
                        <td><a href="{{ route('admin_deletePost', array('slug' => $p->slug, 'id' => $p->id)) }}" class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@stop
