@extends('layout.admin')

@section('content')
<div class="container">
	<div class="col-md-10">
		<h2>Edit: {{ $forum->name }}</h2>

		{{ Form::open(array('route' => array('admin_forum_edit', 'slug' => $forum->slug, 'id' => $forum->id))) }}
			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" name="title" class="form-control" value="{{ $forum->name }}">
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" class="form-control" cols="30" rows="10">{{ $forum->description }}</textarea>
			</div>

			<div class="form-group">
				<label for="parent_id">Parent forum</label>
				<select name="parent_id" class="form-control">
					<!-- Selectionne le forum parent par defaut -->
					@if($forum->getCategory() != null)
						<option value="{{ $forum->parent_id }}" selected>{{ $forum->getCategory()->name }} (Default)</option>
					@endif<!-- /Selectionne le forum parent par defaut -->
					@foreach($categories as $c)
						<option value="{{ $c->id }}">{{ $c->name }}</option>
						{{-- @foreach($c->getForumsInCategory() as $f)
							<option value="{{ $f->id }}">---- {{ $f->name }}</option>
						@endforeach --}}
					@endforeach
				</select>
			</div>

			<div class="form-group">
				<label for="position">Position</label>
				<input type="text" name="position" class="form-control" placeholder="The position number" value="{{ $forum->position }}">
			</div>

			<h3>Permissions</h3>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Groups</th>
						<th>View the forum</th>
						<th>Read topics</th>
						<th>Start new topic</th>
						<th>Reply to topics</th>
						<th>Upload</th>
						<th>Download</th>
					</tr>
				</thead>
				<tbody>
					@foreach($groups as $g)
						<tr>
							<td>{{ $g->name }}</td>
							<td>
								@if($g->getPermissionsByForum($forum)->show_forum == true)
									<input type="checkbox" checked name="permissions[{{ $g->id }}][show_forum]" value="1">
								@else
									<input type="checkbox" name="permissions[{{ $g->id }}][show_forum]" value="1">
								@endif
							</td>
							<td>
								@if($g->getPermissionsByForum($forum)->read_topic == true)
									<input type="checkbox" checked name="permissions[{{ $g->id }}][read_topic]" value="1">
								@else
									<input type="checkbox" name="permissions[{{ $g->id }}][read_topic]" value="1">
								@endif
							</td>
							<td>
								@if($g->getPermissionsByForum($forum)->start_topic == true)
									<input type="checkbox" checked name="permissions[{{ $g->id }}][start_topic]" value="1">
								@else
									<input type="checkbox" name="permissions[{{ $g->id }}][start_topic]" value="1">
								@endif
							</td>
							<td>
								@if($g->getPermissionsByForum($forum)->reply_topic == true)
									<input type="checkbox" checked name="permissions[{{ $g->id }}][reply_topic]" value="1">
								@else
									<input type="checkbox" name="permissions[{{ $g->id }}][reply_topic]" value="1">
								@endif
							</td>
							<td>
								@if($g->getPermissionsByForum($forum)->upload == true)
									<input type="checkbox" checked checked name="permissions[{{ $g->id }}][upload]" value="1">
								@else
									<input type="checkbox" name="permissions[{{ $g->id }}][upload]" value="1">
								@endif
							</td>
							<td>
								@if($g->getPermissionsByForum($forum)->download == true)
									<input type="checkbox" checked checked name="permissions[{{ $g->id }}][download]" value="1">
								@else
									<input type="checkbox" name="permissions[{{ $g->id }}][download]" value="1">
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

			<button type="submit" class="btn btn-default">Save Forum</button>
		{{ Form::close() }}
	</div>
</div>
@stop
