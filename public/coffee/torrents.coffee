class Comment extends Backbone.Model
	urlRoot: '/api/comments/torrent'

class Comments extends Backbone.Collection
	model: Comment
	url: '/api/comments/torrent'

class Torrent extends Backbone.Model
	urlRoot: '/api/torrents'

class Torrents extends Backbone.Collection
	model: Torrent,
	url: '/api/torrents'

class TorrentView extends Backbone.View
	el: '.container-fluid'
	template: null
	torrent_id: null
	torrent_slug: null
	torrent: null
	template: null
	events:
		"click .view-torrent": "viewTorrent"
		"submit #add-comment": "addComment"

	initialize: ->
		console.log('TorrentView initialized')
		@comments = new Comments()
		@comments.on(
			'change'
			@render
			@
		)

	viewTorrent: (event) ->
		event.preventDefault()
		self = @

		@torrent_id = $(event.currentTarget).data('id')
		@torrent_slug = $(event.currentTarget).data('slug')
		@torrent = new Torrent(
			id: @torrent_id 
			slug: @torrent_slug
		)
		
		@torrent.fetch(
			success: ->
				self.comments.fetch(
					data:
						torrent_id: self.torrent_id
						torrent_slug: self.torrent_slug
					success: () ->
						self.render()
				)
			)

	render: ->
		$(@el).find('.right').slideUp()
		template = $("#torrent_template").html()
		@template = _.template(template, 
			torrent: @torrent.toJSON()
			comments: @comments.toJSON()
			)
		$(@el).find('.right').html(@template)
		$(@el).find('.right').slideDown()

	addComment: (event) ->
		event.preventDefault()
		self = @
		comment = new Comment(
			torrent_id: self.torrent_id
			torrent_slug: self.torrent_slug
			content: $(event.currentTarget).find('[name=content]').val()
		)
		comment.save()
		@comments.fetch(
			data:
				torrent_id: self.torrent_id
				torrent_slug: self.torrent_slug
			success: () ->
				self.render()
		)


torrentView = new TorrentView()