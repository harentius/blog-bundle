import './ckeditor-loader';
import './ckeditor-image-resize-attributes-to-url';

// Workaround to get jQuery from global scope as it is already used by Sonata
let $ = window.$;

$(() => {
  $('[name$="[published]"]').on('ifChecked', function() {
    let $publishedAtInput;
    $publishedAtInput = $('[name$="[publishedAt]"]');

    if (!$publishedAtInput.val()) {
      $publishedAtInput.closest('.input-group').find('.fa-calendar').trigger('click').trigger('click');
    }
  });
});
