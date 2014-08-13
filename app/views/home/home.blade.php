@extends('layout.default')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 left">
            @foreach($posts as $p)
            <section class="post">
                <h2 class="post-title"><a data-id="{{ $p->id }}" class="post-read-more" href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}">{{{ $p->title }}}</a></h2>
                <div class="post-time">
                    <time itemprop="datePublished" datetime="{{ date('Y-m-d', strtotime($p->created_at)) }}">{{ date('d M Y', strtotime($p->created_at)) }}</time>
                </div>
                <div class="post-brief">
                    <p>{{{ substr(strip_tags($p->content), 0, 256) }}}...</p>
                </div>
                <div class="post-more">
                    <a href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}" data-id="{{ $p->id }}" class="post-read-more btn btn-default">{{ trans('traduction.read_more') }}</a>
                </div>
                <div class="clearfix"></div>
            </section>
            @endforeach

            {{ $posts->links() }}
        </div>

        <div class="col-md-6 right"></div>
    </div>
</div>
@stop

@section('javascripts')
<script type="text/javascript" src="{{ url('js/vendor/lodash.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/vendor/backbone.min.js') }}"></script>

<script type="text/template" id="article_template">
    <article>
        <h2 class="post-title"><%= article.title %></h2>
        <div class="post-time"><%= article.created_at %></div>
        <div class="post-content">
            <%= article.content %>
        </div>
    </article>
    <hr/>
    <form id="add-comment" data-id="<%= article.id %>" data-slug="<%= article.slug %>" method="POST" accept-charset="UTF-8">
            <div class="form-group">
                <label for="content">Your comment:</label>
                <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-default">Save my comment</button>
    </form>
    <hr/>
    <div class="comments">
        <% _.forEach(comments, function(comment) { %>
            <div class="comment">
                <strong><%= comment.username %></strong> -
                <span><time pubdate><%= comment.created_at %></time></span>
                <blockquote><%= comment.content %></blockquote>
            </div>
        <% }) %>
    </div>
</script>

<script type="text/javascript" src="{{ url('js/home.js') }}"></script>
@stop