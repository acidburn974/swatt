@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        <h2>torrents</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($torrents as $t)
                    <tr>
                        <td>{{ $t->id }}</a></td>
                        <td><a href="{{ route('admin_torrent_edit', array('slug' => $t->slug, 'id' => $t->id)) }}">{{ $t->name }}</a></td>
                        <td><a href="{{ route('admin_torrent_delete', ['slug' => $t->slug, 'id' => $t->id]) }}" class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        {{ $torrents->links() }}
    </div>
</div>
@stop
