@extends('layout.default')

@section('content')
<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 box">
            @foreach($posts as $p)
            <section class="post">
                <h2 class="post-title"><a data-id="{{ $p->id }}" class="post-read-more" href="{{ route('post', array('slug' => $p->slug, 'id' => $p->id)) }}">{{{ $p->title }}}</a></h2>
                <div class="post-time"><time datetime="{{ date('d-m-Y h:m', strtotime($p->created_at)) }}">{{ date('d M Y', strtotime($p->created_at)) }}</time></div>
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
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/lodash.min.js') }}"></script>
<script type="text/javascript" src="{{ url('js/backbone.min.js') }}"></script>

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

<script>
    var Comment = Backbone.Model.extend({
        initialize: function() {},
        urlRoot: '/api/comments'
    });

    var Comments = Backbone.Collection.extend({
        model: Comment,
        url: '/api/comments',
    });

    var Article = Backbone.Model.extend({
        initialize: function() {},
        urlRoot: '/api/article',
    });

    var PostView = Backbone.View.extend({
        el: '.container-fluid',
        template: null,
        comments: null,
        events: {
            "click a.post-read-more": "show",
            "submit #add-comment": "addComment",
        },
        article: null,
        initialize: function() {
            console.log('PostView initialized');
            this.comments = new Comments();
            this.comments.on('change', this.render, this);
        },
        show: function(event) {
            var self = this;
            event.preventDefault();                
            this.article_id = $(event.currentTarget).data('id');
            self.comments.fetch({data: {article_id: self.article_id}, success: function() { self.render(); } });
            this.article = new Article({id:  this.article_id});
            this.article.fetch({
                success: function(article) {
                    self.render();
                    
                }
            });
        },
        render: function() {
            this.$el.find('.right').hide();
            this.template = _.template($("#article_template").html(), {'article': this.article.toJSON(), 'comments': this.comments.toJSON() });
            this.$el.find('.right').html(this.template);
            this.$el.find('.right').fadeIn("fast");
        },
        addComment: function(event) {
            event.preventDefault();
            var self = this;
            var comment = new Comment({
                article_id: this.article_id,
                article_slug: $(event.currentTarget).data('slug'),
                content: $(event.currentTarget).find('[name=content]').val()
            });
            comment.save();
            self.comments.fetch({data: {article_id: self.article_id}, success: function() { self.render(); } });
        }
    });
    var postView = new PostView();
</script>
@stop