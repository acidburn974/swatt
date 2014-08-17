@extends('layout.default')

@section('title')
<title>Forums  - {{{ Config::get('other.title') }}}</title>
@stop

@section('meta_description')
<meta name="description" content="{{{ 'Forum de partage et d\'échange de ' . Config::get('other.title') . '. Téléchargez vos films et séries préférez en torrent. Rejoignez la communauté.' }}}">
@stop


@section('breadcrumb')
<div class="l-breadcrumb-item" itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
	<a href="{{ route('forum_index') }}" itemprop="url" class="l-breadcrumb-item-link">
		<span itemprop="title" class="l-breadcrumb-item-link-title">Forums</span>
	</a>
</div>
@stop

@section('content')
<div class="box container">
	@foreach($categories as $c)
		<!-- Verifie les permissions du groupe et du forum -->
		@if($c->getPermission() != null && $c->getPermission()->show_forum == true && $c->getForumsInCategory()->count() > 0) 
		<div class="f-category" id="category_{{ $c->id }}">
			<!-- Titre de la categorie -->
			<div class="f-category-title col-md-12">
				<h2><a href="{{ route('forum_category', array('slug' => $c->slug, 'id' => $c->id)) }}">{{ $c->name }}</a></h2>
			</div><!-- /Titre de la categorie -->
			<!-- Wrapper -->
			<div class="f-category-table-wrapper col-md-12">
				<table class="f-category-forums table">
					<!-- Hidden thead -->
					<thead class="f-category-forums-hidden">
						<tr>
							<th></th>
							<th>Forum</th>
							<th>Stats</th>
							<th>Last message</th>
						</tr>
					</thead><!-- /Hidden thead -->
					<!-- Liste des forums -->
					<tbody>
						@foreach($c->getForumsInCategory() as $f)
							<tr>
								<!-- Icon -->
								<td class="f-category-forums-icon">
									<img src="{{ url('img/f_icon_read.png') }}">
								</td><!-- /Icon -->
								
								<!-- Forum title -->
								<td>
									<h4 class="f-category-forums-title">
										<a href="{{ route('forum_display', array('slug' => $f->slug, 'id' => $f->id)) }}">{{{ $f->name }}}</a>
									</h4>
									<br>
									<p class="f-category-forums-description">{{{ $f->description }}}</p>
								</td><!-- /Forum title -->

								<!-- Stats -->
								<td class="f-category-forums-stats">
									<ul>
										<li class="f-category-forums-item"><strong>{{ $f->num_topic }}</strong> {{{ trans('forum.topics') }}}</li>
										<li class="f-category-forums-item"><strong>{{ $f->num_post }}</strong> {{{ trans('forum.replies') }}}</li>
									</ul>
								</td><!-- /Stats -->

								<!-- Last post -->
								<td>
									<ul class="f-category-forums-last-post">
										<li class="f-category-forums-last-post-item"><a href="{{ route('forum_topic', array('slug' => $f->last_topic_slug, 'id' => $f->last_topic_id)) }}">{{ $f->last_topic_name }}</a></li>
										<li class="f-category-forums-last-post-item">
											By 
											<a href="{{ route('profil', ['username' => $f->last_post_user_username, 'id' => $f->last_post_user_id]) }}">{{ $f->last_post_user_username }}</a>
										</li>
										<li class="f-category-forums-last-post-item">
											<time datetime="{{ date('d-m-Y h:m', strtotime($f->updated_at)) }}">
												{{ date('d M Y', strtotime($f->updated_at)) }}
											</time>
										</li>
									</ul>
								</td><!-- /Last post -->

							</tr>
						@endforeach
					</tbody><!-- /Liste des forums -->
				</table>
			</div><!-- /Wrapper -->
		</div>
		@endif
	@endforeach
</div>
@stop
