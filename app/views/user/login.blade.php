@extends('layout.default')

@section('title')
<title>{{ trans('messages.login') }} | {{ Config::get('other.title') }}</title>
@stop

@section('meta_description')
<meta name="description" content="Login now on {{{ Config::get('other.title') }}}. Download and share torrents. Not yet member ? Signup in less than 30s.">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ url('/login') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('messages.torrents') }}</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
    <div class="col-md-4">
        <h3>{{ trans('messages.login') }}</h3>
        {{ Form::open(array('route' => 'login')) }}
            <div class="form-group">
                <label for="username">{{ trans('messages.username') }}</label>
                <input type="text" name="username" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">{{ trans('messages.password') }}</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">{{ trans('messages.login') }}</button>
        {{ Form::close() }}
    </div>
</div>
@stop
