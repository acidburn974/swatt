@extends('layout.default')

@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
	</a>
</div>
@stop

@section('content')
<div class="forum box container">
	<div class="col-md-12">
		@foreach($nodes as $node)
			<div class="forum-node">
				<div class="forum-node-title"><a href="{{ route('forum_category', array('slug' => $node->slug, 'id' => $node->id)) }}">{{ $node->name }}</a></div>
				<div class="forum-node-forums">
					@foreach($node->forums as $forum)
						<div class="forum-node-forums-f">
							<div class="forum-node-forums-f-text">
								<a href="{{ route('forum_display', array('slug' => $forum->slug, 'id' => $forum->id)) }}">{{ $forum->name }}</a>
							</div>
							<div class="forum-node-forums-f-last-post">
								<a href=""></a>
							</div>
							<!-- <div class="forum-node-forums-f-data">Discussions: 1337 - Messages: 47 </div> -->
							<div class="clearfix"></div>
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</div>
@stop
