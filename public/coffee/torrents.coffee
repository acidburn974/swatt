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

	initialize: ->
		console.log('TorrentView initialized')

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
				self.render()
			)

	render: ->
		$(@el).find('.right').hide()

		template = $("#torrent_template").html()
		@template = _.template(template, torrent: @torrent.toJSON())
		$(@el).find('.right').html(@template)

		$(@el).find('.right').fadeIn("slow")



torrentView = new TorrentView()