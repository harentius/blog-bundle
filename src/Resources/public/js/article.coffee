((global, $) ->
  'use strict'

  Blog = global.Blog

  $(() ->
    initialized = { '#vk-comments': false, '#disqus_thread': false }

    initComments = (type) ->
      return if initialized[type]

      switch type
        when '#disqus_thread'
          # Disqus API needs this variable. So please don't warn of unused variable
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
          return if typeof VK is 'undefined'

          VK.Widgets.Comments(
            "vk-comments",
            { limit: 5, attach: "*", pageUrl: Blog.crate.get('article_url') },
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
