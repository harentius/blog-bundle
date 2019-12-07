import Quill from 'quill';
import { ImageUpload } from 'quill-image-upload';
import BlotFormatter from 'quill-blot-formatter';
import hljs from '../../hljs';
import 'quill/dist/quill.snow.css';
import '../../../css/admin.scss';

const toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],
  ['blockquote', 'code-block'],
  [{ header: [2, 3, 4, 5, 6, false] }],
  [{ script: 'sub' }, { script: 'super' }],
  [{ align: [] }],
  ['link', 'image', 'video'],
  ['clean'],
];

const initWysiwyg = (selector, options = { height: 400 }) => {
  Quill.register('modules/imageUpload', ImageUpload);
  Quill.register('modules/blotFormatter', BlotFormatter);

  document.querySelectorAll(selector).forEach((el, i) => {
    const id = `quilleditor-${i}`;

    const div = document.createElement('div');
    div.setAttribute('id', id);
    div.style.height = `${options.height}px`;
    div.innerHTML = el.value;

    el.classList.add('d-none');
    el.parentElement.appendChild(div);

    const quill = new Quill(`#${id}`, {
      modules: {
        syntax: {
          highlight: text => hljs.highlightAuto(text).value,
        },
        toolbar: toolbarOptions,
        imageUpload: {
          url: window.Routing.generate('harentius_blog_admin_file_upload'),
          method: 'POST',
          name: 'file',
          withCredentials: true,
          callbackOK: (serverResponse, next) => next(serverResponse.uri),
          callbackKO: serverError => console.log(serverError),
        },
        blotFormatter: {},
      },
      theme: 'snow',
    });
    quill.on('text-change', () => {
      // eslint-disable-next-line no-param-reassign
      el.value = quill.root.innerHTML;
    });
  });
};

export default initWysiwyg;
