@extends('layout.default')

@section('title')
	<title>Contact - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta')
	<meta name="description" content="Page de contact de {{{ Config::get('other.title') }}}. {{{ 'Une requête ? Une question ? Contactez nous ici !' }}}">
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('contact') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Contact</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
	<div class="col-md-4 box centered-form">
		{{ Form::open(array('route' => 'contact')) }}

			<div class="form-group">
				<input type="text" name="contact-name" placeholder="Your name" class="form-control">
			</div>
			
			<div class="form-group">
				<input type="email" name="email" placeholder="E-mail" class="form-control">
			</div>

			<div class="form-group">
				<textarea name="message" placeholder="Message" class="form-control" cols="30" rows="10"></textarea>
			</div>
			
			<button type="submit" class="btn btn-lg btn-primary btn-block">Envoyer</button>
		{{ Form::close() }}
	</div>
</div>
@stop