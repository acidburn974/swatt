class Topic extends Backbone.Model

class Topics extends Backbone.Model
    model: Topic
    url: url + '/api/forums/display'

class ForumView extends Backbone.View

    el: "#l-content"

    forumDisplayHtml: null

    template: null

    events:
        "click a.f-category-forums-title-link": "displayForum"

    topics: null

    forum_id: 0

    initialize: () ->
        console.log('Forum View initialized')
        self = @
        $.get(url + '/js/templates/forum/forum_display.html', (response) -> self.forumDisplayHtml = response) # Load HTML Template for displaying
        @topics = new Topics()

    displayForum: (event) ->
        self = @
        @forum_id = $(event.currentTarget).data('forum-id')
        event.preventDefault()
        #console.log(event)
        #console.log($(event.currentTarget).data('forum-id'))

        @topics.fetch({data: {forum_id: @forum_id}, success: () -> self.render()})
      
    render: () ->
        console.log('Rendering started')


fv = new ForumView()
