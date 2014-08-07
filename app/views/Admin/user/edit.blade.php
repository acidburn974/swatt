@extends('layout.admin')

@section('content')
<div class="container">
    <div class="col-md-10">
        {{ Form::open(array('route' => ['admin_user_edit', 'username' => $user->username, 'id' => $user->id])) }}

            <div class="form-group">
                <label for="username">Username</label>
                <input name="username" type="text" value="{{ $user->username }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input name="email" type="email" value="{{ $user->email }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="join-date">Join date</label>
                <input name="join-date" type="join-date" value="{{ date('d/m/Y', strtotime($user->created_at)) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="about">About</label>
                <textarea name="about" cols="30" rows="10" class="form-control">{{ $user->about }}</textarea>
            </div>

            <div class="form-group">
                <select name="group_id" class="form-control">
                    <option value="{{ $user->group->id }}">{{ $user->group->name }} (Default)</option>
                    @foreach($groups as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-default">Save</button>

        {{ Form::close() }}
    </div>
</div>
@stop
