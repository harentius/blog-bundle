((global, $) ->
  'use strict'

  $(() ->
    $('[name$="[isPublished]"]').on('ifChecked', () ->
      $publishedAtInput = $('[name$="[publishedAt]"]')

      if not $publishedAtInput.val()
        $publishedAtInput.closest('.input-group')
          .find('.fa-calendar')
          # TODO: fix this workaround/quick solution. Need to clock twice for unshowing datepicker.
          # And this function is not available on the time being: http://eonasdan.github.io/bootstrap-datetimepicker/Functions/#usecurrent
          # Other functions not changes viewing date
          .trigger('click').trigger('click')
    )
  )
)(window, jQuery)
