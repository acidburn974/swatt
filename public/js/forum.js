var ForumView, Topic, Topics, fv,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Topic = (function(_super) {
  __extends(Topic, _super);

  function Topic() {
    return Topic.__super__.constructor.apply(this, arguments);
  }

  return Topic;

})(Backbone.Model);

Topics = (function(_super) {
  __extends(Topics, _super);

  function Topics() {
    return Topics.__super__.constructor.apply(this, arguments);
  }

  Topics.prototype.model = Topic;

  Topics.prototype.url = url + '/api/forums/display';

  return Topics;

})(Backbone.Model);

ForumView = (function(_super) {
  __extends(ForumView, _super);

  function ForumView() {
    return ForumView.__super__.constructor.apply(this, arguments);
  }

  ForumView.prototype.el = "#l-content";

  ForumView.prototype.forumDisplayHtml = null;

  ForumView.prototype.events = {
    "click a.f-category-forums-title-link": "displayForum"
  };

  ForumView.prototype.topics = null;

  ForumView.prototype.forum_id = 0;

  ForumView.prototype.initialize = function() {
    var self;
    console.log('Forum View initialized');
    self = this;
    $.get(url + '/js/templates/forum/forum_display.html', function(response) {
      return self.forumDisplayHtml = response;
    });
    return this.topics = new Topics();
  };

  ForumView.prototype.displayForum = function(event) {
    var self;
    self = this;
    this.forum_id = $(event.currentTarget).data('forum-id');
    event.preventDefault();
    return this.topics.fetch({
      data: {
        forum_id: this.forum_id
      },
      success: function() {
        return console.log(self.topics.toJSON());
      }
    });
  };

  return ForumView;

})(Backbone.View);

fv = new ForumView();
