import './loader.js'
import 'ckeditor/ckeditor'

import './plugins/wordcount';
import './plugins/youtube';
import './plugins/audio';
import './plugins/wpmore';

window.onload = function() {
  window.CKEDITOR.replace(document.getElementsByClassName('ckeditor')[0], {});
};
