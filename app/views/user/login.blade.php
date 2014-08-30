@extends('layout.default')

@section('title')
<title>{{{ trans('common.login') }}} - {{ Config::get('other.title') }}</title>
@stop

@section('meta')
<meta name="description" content="Login now on {{{ Config::get('other.title') }}}. Download and share torrents. Not yet member ? Signup in less than 30s.">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ url('/login') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{{ trans('common.login') }}}</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
    <div class="col-md-4 box centered-form">
        <h3>{{{ trans('common.login') }}}</h3>
        {{ Form::open(array('route' => 'login')) }}
            <div class="form-group">
                <label for="username">{{ trans('common.username') }}</label>
                <input id="input-username" type="text" name="username" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">{{ trans('common.password') }}</label>
                <input id="input-password" type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">{{{ trans('common.login') }}}</button>
        {{ Form::close() }}
    </div>
</div>
@stop

