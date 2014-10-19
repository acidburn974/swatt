@extends('layout.default')

@section('title')
    <title>Inviter une personne - {{{ Config::get('other.title') }}}</title>
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('members') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Membres</span>
    </a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('user_invite') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Lancer une invitation</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
    <div class="col-md-4 box">
        <h1>Inviter quelqu'un</h1>
        {{ Form::open(array('route' => 'user_invite')) }}

            <div class="form-group">
                <label for="email">Adresse email</label>
                <input type="email" name="email" class="form-control" placeholder="exemple@tld.com">
            </div>

            <button type="submit" class="btn btn-default">Inviter</button>

        {{ Form::close() }}
    </div>
</div>
@stop
