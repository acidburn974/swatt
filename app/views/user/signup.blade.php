@extends('layout.default')

@section('title')
<title>Signup - {{ Config::get('other.title') }}</title>
@stop

@section('meta_description')
<meta name="description" content="Need a content here !">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ url('/signup') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('messages.signup') }}</span>
    </a>
</div>
@stop

@section('content')
<div class="box container">
    <div class="col-md-4">
        <h3>{{ trans('messages.signup') }}</h3>
        {{ Form::open(array('route' => 'signup')) }}
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-default">{{ trans('messages.signup') }}</button>
        {{ Form::close() }}
    </div>
</div>
@stop
