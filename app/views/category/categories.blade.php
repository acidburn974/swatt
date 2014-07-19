@extends('layout.default')

@section('title')
<title>Categories - {{ Config::get('other.title') }}</title>
@stop

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
    <a href="{{ route('categories') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">Categories</span>
    </a>
</div>
@stop

@section('content')
<div class="container">
    <div class="categories col-md-12">
        @foreach($categories as $c)
            <span class="categories-word">
                <a href="{{ route('category', array('slug' => $c->slug, 'id' => $c->id)) }}">{{ $c->name }}</a>
            </span>
        @endforeach
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
@stop
