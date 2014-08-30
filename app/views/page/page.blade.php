@extends('layout.default')

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('page', ['slug' => $page->slug, 'id' => $page->id]) }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">{{ $page->name }}</span>
	</a>
</div>
@stop

@section('content')
<div class="container box">
	<div class="col-md-12 page">
		<div class="page-title"><h1>{{ $page->name }}</h1></div>

		<article class="page-content">
			{{ $page->content }}
		</article>
	</div>
</div>
@stop