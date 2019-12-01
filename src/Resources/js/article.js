import {configReader} from "./config-reader";

const initialized = {
  '#disqus_thread': false
};

const initComments = function(type) {
  if (initialized[type]) {
    return;
  }

  switch (type) {
    case '#disqus_thread':
      window.disqus_config = function() {
        this.page.url = configReader.get('article_url');
        this.page.identifier = configReader.get('page_identifier');
      };

      (function() {
        const d = window.document;
        const s = d.createElement('script');
        s.src = `//${configReader.get('discuss_user_name')}.disqus.com/embed.js`;
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
      })();

      break;
    default: return;
  }

  initialized[type] = true;
};

$(function() {
  const $tabToggler = $('.comments-wrapper a[data-toggle="tab"]');

  $tabToggler.on('shown.bs.tab', (e) => {
    initComments($(e.target).attr("href"))
  });

  initComments($tabToggler.closest('.active').find('a[data-toggle="tab"]').attr('href'));
});
