((global, $) ->
  'use strict'

  global.Blog || (global.Blog = {})
  Blog = global.Blog

  storage = {}
  defaults = {}

  Blog.crate =
    set: (key, value) ->
      storage[key] = value

    add: (values) ->
      storage = $.extend(storage, values)

    unset: (key) ->
        delete storage[key]

    get: (key, def) ->
      return storage[key] if Blog.crate.has(key)
      return def if typeof(def) != "undefined"
      return defaults[key]

    has: (key) ->
      return storage.hasOwnProperty(key) && storage[key] != null

    all: () ->
      return storage

    clear: () ->
        storage = {}

    setDefaults: (key, value) ->
        defaults[key] = value

    addDefaults: (newDefaults) ->
        defaults = $.extend(defaults, newDefaults)

    unsetDefaults: (key) ->
        delete defaults[key]

    clearDefaults: () ->
        defaults = {}
)(window, jQuery)
