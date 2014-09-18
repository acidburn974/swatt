(function() {
  var Comment, Comments, CommentsView,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

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

  CommentsView = (function(_super) {
    __extends(CommentsView, _super);

    function CommentsView() {
      return CommentsView.__super__.constructor.apply(this, arguments);
    }

    CommentsView.prototype.el = "#comments";

    CommentsView.prototype.initialize = function() {
      var articleId;
      return articleId = $(this.el).data('article-id');
    };

    return CommentsView;

  })(Backbone.View);

}).call(this);
