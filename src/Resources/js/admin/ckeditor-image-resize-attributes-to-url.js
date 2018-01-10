import {configReader} from "../config-reader";

window.CKEDITOR.on('instanceReady', function(ev) {
  const { editor } = ev;
  const widgetInstances = editor.widgets.instances;

  for (let instance of Array.from(widgetInstances)) {
    if (instance.name === 'image2') {
      return;
    }
  }

  let $resizingImage = null;

  // Workaround to get jQuery from global scope as it is already used by Sonata
  const { $ } = window;
  const targetDir = configReader.get('image_previews_base_uri');

  $(editor.document.$).on('mousedown', '.cke_image_resizer', function() {
    return $resizingImage = $(this).closest('.cke_widget_wrapper').find('img[data-cke-saved-src]');
  });

  $(editor.document.$).on('mouseup', function() {
    if (!$resizingImage) {
      return;
    }

    const urlParts = $resizingImage.attr('src').match(/\/([^\/]*?)(_\d+x\d+)?(\.[0-9a-z]+)$/i);

    if (!urlParts[1] || !urlParts[3]) {
      return;
    }

    const sizeString = `_${$resizingImage.attr('width')}x${$resizingImage.attr('height')}`;
    const src = [targetDir, urlParts[1], sizeString, urlParts[3]].join('');

    $resizingImage.attr('data-cke-saved-src', src);
    $resizingImage.attr('src', src);

    return $resizingImage = null;
  });
});
