@extends('layout.default')

@section('title')
<title>{{{ trans('common.lost-password') }}} - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
<meta name="description" content="{{{ 'Récupération de mot de passe' }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ url('/lost-password') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('common.lost-password') }}</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
	<div class="col-md-4 centered-form box">
		<h2>{{{ trans('common.lost-password') }}}</h2>
		{{ Form::open(['route' => ['reminder_get_remind']]) }}
			
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="E-mail">
			</div>

			<button type="submit" class="btn btn-primary btn-block">Send</button>

		{{ Form::close() }}
	</div>
</div>
@stop