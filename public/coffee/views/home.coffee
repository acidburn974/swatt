class Article extends Backbone.Model

    urlRoot: '/api/articles'

    initialize: () ->
        console.log("Article Model initialized")

class Comment extends Backbone.Model

    urlRoot: '/api/comments'

class Comments extends Backbone.Collection

    model: Comment

    url: 'api/comments/article'

class Home extends Backbone.View

    el: "#l-content"

    article: null

    sourceHtml: null

    template: null

    events:
        "click .article-thumb": "article"
        "click .article-title>h2>a": "article"
        "click .article-readmore": "article"

    initialize: () ->
        console.log('Home View initialized')
        self = @
        $.get('/js/templates/article.html', (data) -> 
            self.sourceHtml = data
        )

    article: (event) ->
        event.preventDefault()
        self = @
        articleId = $(event.currentTarget).parents(".article").data('id')
        @article = new Article(id: articleId)
        @article.fetch(
            success: () ->
                self.render()
            error: () ->
                console.log("Error loading post: " + articleId)
        )

    comment: (event) ->
        event.preventDefault()
        content = $("#article-comment-content").val()
        comment = new Comment({id: null, content: content})
        comment.save(
            success: () ->
                
        )

    render: () ->
        html = Mustache.render(@sourceHtml, {article: @article.toJSON()})
        $(@el).html(html)

h = new Home()