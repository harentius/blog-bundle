import configReader from '../config-reader';

document.addEventListener('DOMContentLoaded', () => {
  fetch(window.Routing.generate('harentius_blog_view_count', {
    id: configReader.get('article_id'),
  }), {
    method: 'post',
  });
});
