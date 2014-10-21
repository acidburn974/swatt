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
        <h1>Editer mon profil</h1>

        {{ Form::open(array('route' => array('user_edit_profil', 'username' => $user->username, 'id' => $user->id), 'files' => true)) }}

            <div class="form-group">
                <label for="image">Photo de profil</label>
                <input type="file" name="image">
            </div>

            <div class="form-group">
                <label for="title">Choisisser un titre</label>
                <input type="text" name="title" class="form-control" value="{{ $user->title }}">
            </div>

            <div class="form-group">
                <label for="about">Dites nous en plus à propos de vous</label>
                <textarea name="about" cols="30" rows="10" class="form-control">{{ $user->about }}</textarea>
            </div>

            <div class="form-group">
                <label for="signature">Signature du forum (BBCode)</label>
                <textarea name="signature" id="" cols="30" rows="10" class="form-control">{{ $user->signature }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        {{ Form::close() }}

    </div>
</div>
@stop