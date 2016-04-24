((CKEDITOR, $) ->
  CKEDITOR.on('instanceReady', (ev) ->
    editor = ev.editor
    widgetInstances = editor.widgets.instances

    for instance in widgetInstances
      if instance.name == 'image2'
        return

    $resizingImage = null
    targetDir = Blog.crate.get('image_previews_base_uri')

    $(editor.document.$).on('mousedown', '.cke_image_resizer', () ->
      $resizingImage = $(this).closest('.cke_widget_wrapper').find('img[data-cke-saved-src]')
    )

    $(editor.document.$).on('mouseup', () ->
      return if not $resizingImage

      urlParts = $resizingImage.attr('src').match(/\/([^\/]*?)(_\d+x\d+)?(\.[0-9a-z]+)$/i)

      return if not urlParts[1] || not urlParts[3]

      sizeString = "_#{$resizingImage.attr('width')}x#{$resizingImage.attr('height')}"
      src = [targetDir, urlParts[1], sizeString, urlParts[3]].join('')
      $resizingImage.attr('data-cke-saved-src', src)
      $resizingImage.attr('src', src)
      $resizingImage = null;
    )
  )
)(CKEDITOR, jQuery)
