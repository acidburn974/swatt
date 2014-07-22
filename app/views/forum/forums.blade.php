@extends('layout.default')

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('community') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Community</span>
	</a>
</div>
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('node', array('slug' => $node->slug, 'id' => $node->id)) }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">{{ $node->name }}</span>
	</a>
</div>
@stop

@section('content')
<div class="forum container">
	<div class="col-md-9">
	</div>
</div>
@stop