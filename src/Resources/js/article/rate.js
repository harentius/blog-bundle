import configReader from '../config-reader';

const articleId = configReader.get('article_id');

const increaseValue = (selector) => {
  const value = selector.querySelector('.value');
  value.innerText = parseInt(value.innerText, 10) + 1;
};

const processRateChange = (button, type, changeClassFrom, changeClassTo) => {
  if (button.classList.contains('disabled')) {
    return;
  }

  const url = `/like/${articleId}/${type}`;
  fetch(url, {
    method: 'POST',
  }).then((response) => {
    if (!response.ok) {
      return;
    }

    const wrapper = button.closest(`.${type}`);
    increaseValue(wrapper);
    const icon = wrapper.querySelector('i');

    icon.classList.remove(changeClassFrom);
    icon.classList.add(changeClassTo);
    wrapper.closest('.likes-wrapper').querySelectorAll('i').forEach(e => e.classList.add('disabled'));
  });
};

document.getElementById('like-action').addEventListener('click', (e) => {
  processRateChange(e.target, 'like', 'fa-thumbs-o-up', 'fa-thumbs-up');
});

document.getElementById('dislike-action').addEventListener('click', (e) => {
  processRateChange(e.target, 'dislike', 'fa-thumbs-o-down', 'fa-thumbs-down');
});
