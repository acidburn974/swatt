var Shout = Backbone.Model.extend({

	urlRoot: '/api/shout',

	initialize: function() {

	}
});

var Shouts = Backbone.Collection.extend({

	url: '/api/shout',

	model: Shout,

	initialize: function() {

	}
});

var ShoutView = Backbone.View.extend({

	el: ".shoutbox",

	events: {
		"submit #shoutbox-form": "newShout"
	},

	template: _.template(
	'<tr>' +
		'<td><%= shout.user.username %></td>' +
		'<td><%= shout.created_at %></td>' +
		'<td><%= shout.content %></td>' +
	'</tr>'
	),

	shouts: new Shouts(),

	initialize: function() {
		console.log('Shout View initialized');
		var self = this;

		this.shouts.on('add', this.render, this);
		this.shouts.on('reset', this.render, this);

		this.shouts.fetch({
			success: function() {
				self.render();
			}
		});

		window.setInterval(function() {
			self.shouts.fetch({ add: true });
		}, 2000);
	},

	render: function() {
		var self = this;
		this.$el.find(".shoutbox-shouts").html('');
		this.shouts.each(function(s) {
			//console.log(s.toJSON());
			while(this.$el.find(".shoutbox-shouts").find("tr").length > 5)
			{
				this.$el.find(".shoutbox-shouts").find("tr:first").remove();
			}
			self.$el.find(".shoutbox-shouts").append(self.template({ shout: s.toJSON() }));
		});
	}
});

var sv = new ShoutView();
// sv.render();