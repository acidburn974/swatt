@extends('layout.default')

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('members') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ trans('common.members') }}}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('profil', ['username' => $user->username, 'id' => $user->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ $user->username }}}</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('user_edit_profil', ['username' => $user->username, 'id' => $user->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Edit</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
    <div class="col-md-4 profiledit box">
        <h1>Edit my profile</h1>

        {{ Form::open(array('route' => array('user_edit_profil', 'username' => $user->username, 'id' => $user->id), 'files' => true)) }}

            <div class="form-group">
                <label for="image">Photo</label>
                <input type="file" name="image">
            </div>

            <div class="form-group">
                <label for="title">Your own's title</label>
                <input type="text" name="title" class="form-control" value="{{ $user->title }}">
            </div>

            <div class="form-group">
                <label for="about">Say something about you</label>
                <textarea name="about" cols="30" rows="10" class="form-control">{{ $user->about }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        {{ Form::close() }}

    </div>
</div>
@stop