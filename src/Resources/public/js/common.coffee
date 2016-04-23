'use strict'
hljs.initHighlightingOnLoad()

jQuery(($) ->
  urls =
    rate: (articleId, type) ->
      Routing.generate('harentius_blog_rate', { article: articleId, type: type } )

  $('.months-expander').on('click', () ->
    $this = $(this)

    archiveExpandedYears = Cookies.getJSON('archive-expanded-years') || []
    href = $this.siblings('a').attr('href')
    index = archiveExpandedYears.indexOf(href)
    shouldBeVisible = not $this.siblings('ul').is(':visible')

    if index == -1
      archiveExpandedYears.push(href) if shouldBeVisible
      Cookies.set('archive-expanded-years', archiveExpandedYears)
    else if not shouldBeVisible
      archiveExpandedYears.splice(index, 1)
      Cookies.set('archive-expanded-years', archiveExpandedYears)

    $this.closest('.year-content-wrapper').find('.months-list').slideToggle()
  )

  articleId = $('.social-and-shares-wrapper').data('id')

  increaseValue = ($selector) ->
    $value = $selector.find('.value')
    $value.text(parseInt($value.text()) + 1)

  processRateChange = ($button, type, changeClassFrom, changeClassTo) ->
    return if $button.is('.disabled')

    $.post(urls.rate(articleId, type))
      .done((response, status) ->
        if status == 'success'
          $wrapper = $button.closest('.' + type)
          increaseValue($wrapper)
          $wrapper.find('i').removeClass(changeClassFrom).addClass(changeClassTo)
          $wrapper.closest('.likes-wrapper').find('i').addClass('disabled')
    )

  $('#like-action').on('click', () ->
    processRateChange($(this), 'like', 'fa-thumbs-o-up', 'fa-thumbs-up')
  )

  $('#dislike-action').on('click', () ->
    processRateChange($(this), 'dislike', 'fa-thumbs-o-down', 'fa-thumbs-down')
  )

  archiveExpandedYears = Cookies.getJSON('archive-expanded-years')

  if archiveExpandedYears
    for url in archiveExpandedYears
      $("a[href='#{url}']").siblings('i').trigger('click')
)
