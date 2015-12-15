((global, $) ->
  'use strict'

  Blog = global.Blog

  $(() ->
    initialized = { '#vk-comments': false, '#disqus_thread':false }

    initComments = (type) ->
      return if initialized[type]

      switch type
        when '#disqus_thread'
          disqus_config = () ->
            @.page.url = Blog.crate.get('article_url')
            @.page.identifier = Blog.crate.get('page_identifier')

          (() ->
            d = document
            s = d.createElement('script')
            s.src = "//#{Blog.crate.get('discuss_user_name')}.disqus.com/embed.js"
            s.setAttribute('data-timestamp', +new Date())
            (d.head || d.body).appendChild(s)
          )()
        when '#vk-comments'
          VK.Widgets.Like("vk-like", {type: "full", width: '100%', height: 24});
          VK.Widgets.Comments(
            "vk-comments",
            { limit: 5, attach: "*", pageUrl: Blog.crate.get('article_url') }
            Blog.crate.get('article_original_id')
          )
        else return

      initialized[type] = true

    $tabToggler = $('.comments-wrapper a[data-toggle="tab"]')
    $tabToggler.on('shown.bs.tab', (e) ->
      initComments($(e.target).attr("href"))
    )

    initComments($tabToggler.closest('.active').find('a[data-toggle="tab"]').attr('href'))
  )
)(window, jQuery)
