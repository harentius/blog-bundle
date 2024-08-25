import './loader';
import 'ckeditor4';
import './ckeditor-image-resize-attributes-to-url';

const init = (selector) => {
  document.querySelectorAll(selector).forEach((el) => {
    window.CKEDITOR.replace(el, {
      allowedContent: true,
      language: 'en',
      height: 700,
      removePlugins: 'image,forms',
      removeButtons: '',
      extraPlugins: 'youtube,justify,wpmore,codesnippet,audio,image2,wordcount',
      toolbar: [
        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
        { name: 'paragraph', items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
        { name: 'list', items: ['NumberedList', 'BulletedList'] },
        { name: 'insert', items: ['Blockquote', 'Link', 'Unlink', 'Image', 'Table', 'Youtube', 'Audio', 'CodeSnippet', 'WPMore'] },
        { name: 'styles', items: ['Format'] },
        { name: 'other', items: ['Source'] },
      ],
      wordcount: {
        showParagraphs: false,
      },
      filebrowserUploadUrl: '/admin/file-upload',
      filebrowserBrowseUrl: '/admin/file-browse/image',
      filebrowserAudioBrowseUrl: '/admin/file-browse/audio',
    });
  });
};

export default init;
