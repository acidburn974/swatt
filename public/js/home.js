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
        this.article = new Article({id:  this.article_id});
        this.article.fetch({
            success: function(article) {
                self.comments.fetch({data: {article_id: self.article_id}, success: function() { self.render(); } });
                //self.render();
            }
        });
    },
    render: function() {
        this.$el.find('.right').hide();
        this.template = _.template($("#article_template").html(), {'article': this.article.toJSON(), 'comments': this.comments.toJSON() });
        this.$el.find('.right').show();
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