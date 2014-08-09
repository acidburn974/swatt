var Torrent, TorrentView, Torrents, torrentView,
  __hasProp = {}.hasOwnProperty,
  __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

Torrent = (function(_super) {
  __extends(Torrent, _super);

  function Torrent() {
    return Torrent.__super__.constructor.apply(this, arguments);
  }

  Torrent.prototype.urlRoot = '/api/torrents';

  return Torrent;

})(Backbone.Model);

Torrents = (function(_super) {
  __extends(Torrents, _super);

  function Torrents() {
    return Torrents.__super__.constructor.apply(this, arguments);
  }

  Torrents.prototype.model = Torrent;

  Torrents.prototype.url = '/api/torrents';

  return Torrents;

})(Backbone.Collection);

TorrentView = (function(_super) {
  __extends(TorrentView, _super);

  function TorrentView() {
    return TorrentView.__super__.constructor.apply(this, arguments);
  }

  TorrentView.prototype.el = '.container-fluid';

  TorrentView.prototype.template = null;

  TorrentView.prototype.torrent_id = null;

  TorrentView.prototype.torrent_slug = null;

  TorrentView.prototype.torrent = null;

  TorrentView.prototype.template = null;

  TorrentView.prototype.events = {
    "click .view-torrent": "viewTorrent"
  };

  TorrentView.prototype.initialize = function() {
    return console.log('TorrentView initialized');
  };

  TorrentView.prototype.viewTorrent = function(event) {
    var self;
    event.preventDefault();
    self = this;
    this.torrent_id = $(event.currentTarget).data('id');
    this.torrent_slug = $(event.currentTarget).data('slug');
    this.torrent = new Torrent({
      id: this.torrent_id,
      slug: this.torrent_slug
    });
    return this.torrent.fetch({
      success: function() {
        return self.render();
      }
    });
  };

  TorrentView.prototype.render = function() {
    var template;
    $(this.el).find('.right').hide();
    template = $("#torrent_template").html();
    this.template = _.template(template, {
      torrent: this.torrent.toJSON()
    });
    $(this.el).find('.right').html(this.template);
    return $(this.el).find('.right').fadeIn("slow");
  };

  return TorrentView;

})(Backbone.View);

torrentView = new TorrentView();
