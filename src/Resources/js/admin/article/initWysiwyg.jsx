import React from 'react';
import ReactDOM from 'react-dom';
import Wysiwyg from '../wysiwyg/Wysiwyg';

const initWysiwyg = (selector, options = { height: 400 }) => {
  document.querySelectorAll(selector).forEach((el, i) => {
    const id = `wysiwyg-${i}`;

    const div = document.createElement('div');
    div.setAttribute('id', id);
    div.style.height = `${options.height}px`;
    div.innerHTML = el.value;
    div.classList.add('wysiwyg');

    el.classList.add('d-none');
    el.parentElement.appendChild(div);

    const mountNode = document.getElementById(id);
    ReactDOM.render(<Wysiwyg/>, mountNode);
  });
};

export default initWysiwyg;
