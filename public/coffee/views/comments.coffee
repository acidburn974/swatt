class Comment extends Backbone.Model

    urlRoot: '/api/comments'

class Comments extends Backbone.Collection

    model: Comment

    url: 'api/comments/article'

class CommentsView extends Backbone.View

    el: "#comments"

    initialize: () ->
        articleId = $(@el).data('article-id')