import Cookies from 'js-cookie';
import hljs from './hljs';
import '../css/common.scss';
import '../css/twbs-extension.less';
import '../css/main.less';

hljs.initHighlightingOnLoad();
$(function() {
  const urls = {
    rate(articleId, type) {
      return Routing.generate('harentius_blog_rate', { article: articleId, type } );
    }
  };

  $('.months-expander').on('click', function() {
    const $this = $(this);

    const archiveExpandedYears = Cookies.getJSON('archive-expanded-years') || [];
    const href = $this.siblings('a').attr('href');
    const index = archiveExpandedYears.indexOf(href);
    const shouldBeVisible = !$this.siblings('ul').is(':visible');

    if (index === -1) {
      if (shouldBeVisible) { archiveExpandedYears.push(href); }
      Cookies.set('archive-expanded-years', archiveExpandedYears);
    } else if (!shouldBeVisible) {
      archiveExpandedYears.splice(index, 1);
      Cookies.set('archive-expanded-years', archiveExpandedYears);
    }

    return $this.closest('.year-content-wrapper').find('.months-list').slideToggle();
  });

  const articleId = $('.social-and-shares-wrapper').data('id');

  const increaseValue = function($selector) {
    const $value = $selector.find('.value');
    return $value.text(parseInt($value.text()) + 1);
  };

  const processRateChange = function($button, type, changeClassFrom, changeClassTo) {
    if ($button.is('.disabled')) { return; }

    return $.post(urls.rate(articleId, type))
      .done(function(response, status) {
        if (status === 'success') {
          const $wrapper = $button.closest(`.${type}`);
          increaseValue($wrapper);
          $wrapper.find('i').removeClass(changeClassFrom).addClass(changeClassTo);
          return $wrapper.closest('.likes-wrapper').find('i').addClass('disabled');
        }
      });
  };

  $('#like-action').on('click', function() {
    return processRateChange($(this), 'like', 'fa-thumbs-o-up', 'fa-thumbs-up');
  });

  $('#dislike-action').on('click', function() {
    return processRateChange($(this), 'dislike', 'fa-thumbs-o-down', 'fa-thumbs-down');
  });

  const archiveExpandedYears = Cookies.getJSON('archive-expanded-years');

  if (archiveExpandedYears) {
    return Array.from(archiveExpandedYears).map((url) =>
      $(`a[href='${url}']`).siblings('i').trigger('click'));
  }
});
