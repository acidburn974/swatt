@extends('layout.default')

@section('title')
<title>{{{ trans('common.signup') }}} - {{ Config::get('other.title') }}</title>
@stop

@section('meta_description')
<meta name="description" content="Signup to the torrent tracker in less than 30s. Get access to exclusive HD movies and tv shows.">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ url('/signup') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ trans('common.signup') }}}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <div class="col-md-4">
        <h3>{{{ trans('common.signup') }}}</h3>
        {{ Form::open(array('route' => 'signup')) }}
            <div class="form-group">
                <label for="username">{{{ trans('common.username') }}}</label>
                <input type="text" name="username" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">{{{ trans('common.password') }}}</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">Go !</button>
        {{ Form::close() }}
    </div>
</div>
@stop
