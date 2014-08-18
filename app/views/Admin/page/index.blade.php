@extends('layout.admin')

@section('content')
<div class="container">
	<div class="col-md-10">
		<h2>Pages</h2>
		<a href="{{ route('admin_page_add') }}" class="btn btn-primary">Add a new page</a>

		<table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pages as $page)
                    <tr>
  						<td><a href="{{ route('admin_page_edit', ['slug' => $page->slug, 'id' => $page->id]) }}">{{ $page->name }}</a></td>
  						<td>{{ date('d M Y', $page->created_at->getTimestamp()) }}</td>
  						<td><a href="{{ route('admin_page_delete', ['slug' => $page->slug, 'id' => $page->id]) }}" class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
	</div>
</div>
@stop