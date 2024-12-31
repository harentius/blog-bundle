import configReader from '../config-reader';

document.addEventListener('DOMContentLoaded', () => {
  const articleId = configReader.get('article_id');
  const url = `/view-count/${articleId}`;
  fetch(url, {
    method: 'post',
  });
});
