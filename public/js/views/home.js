(function() {
  var Article, Comment, Comments, Home, h,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  Article = (function(_super) {
    __extends(Article, _super);

    function Article() {
      return Article.__super__.constructor.apply(this, arguments);
    }

    Article.prototype.urlRoot = '/api/articles';

    Article.prototype.initialize = function() {
      return console.log("Article Model initialized");
    };

    return Article;

  })(Backbone.Model);

  Comment = (function(_super) {
    __extends(Comment, _super);

    function Comment() {
      return Comment.__super__.constructor.apply(this, arguments);
    }

    Comment.prototype.urlRoot = '/api/comments';

    return Comment;

  })(Backbone.Model);

  Comments = (function(_super) {
    __extends(Comments, _super);

    function Comments() {
      return Comments.__super__.constructor.apply(this, arguments);
    }

    Comments.prototype.model = Comment;

    Comments.prototype.url = 'api/comments/article';

    return Comments;

  })(Backbone.Collection);

  Home = (function(_super) {
    __extends(Home, _super);

    function Home() {
      return Home.__super__.constructor.apply(this, arguments);
    }

    Home.prototype.el = "#l-content";

    Home.prototype.article = null;

    Home.prototype.sourceHtml = null;

    Home.prototype.template = null;

    Home.prototype.events = {
      "click .article-thumb": "article",
      "click .article-title>h2>a": "article",
      "click .article-readmore": "article"
    };

    Home.prototype.initialize = function() {
      var self;
      console.log('Home View initialized');
      self = this;
      return $.get('/js/templates/article.html', function(data) {
        return self.sourceHtml = data;
      });
    };

    Home.prototype.article = function(event) {
      var articleId, self;
      event.preventDefault();
      self = this;
      articleId = $(event.currentTarget).parents(".article").data('id');
      this.article = new Article({
        id: articleId
      });
      return this.article.fetch({
        success: function() {
          return self.render();
        },
        error: function() {
          return console.log("Error loading post: " + articleId);
        }
      });
    };

    Home.prototype.comment = function(event) {
      var comment, content;
      event.preventDefault();
      content = $("#article-comment-content").val();
      comment = new Comment({
        id: null,
        content: content
      });
      return comment.save({
        success: function() {}
      });
    };

    Home.prototype.render = function() {
      var html;
      html = Mustache.render(this.sourceHtml, {
        article: this.article.toJSON()
      });
      return $(this.el).html(html);
    };

    return Home;

  })(Backbone.View);

  h = new Home();

}).call(this);
