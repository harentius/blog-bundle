window.CKEDITOR.editorConfig = function(config) {
  Object.assign(config, {
    allowedContent: true,
    height: 700,
    removePlugins: 'image,forms',
    extraPlugins: "youtube,justify,div,wpmore,codesnippet,audio,image2,wordcount",
    // TODO: read from symfony parameter at runtime
    language: "en",
    toolbarGroups: [
      {name: "basicstyles", groups: ["basicstyles", "cleanup"]},
      {name: "editing", groups: ["find", "selection"]},
      {name: "align"},
      {name: "paragraph", groups: ["list", "indent", "blocks"]},
      {name: "links"},
      {name: "insert"},
      {name: "styles"},
      {name: "colors"},
      {name: "forms"},
      {name: "clipboard", groups: ["clipboard", "undo"]},
      {name: "document", groups: ["mode", "document", "doctools"]},
      {name: "tools"},
      {name: "others"}
    ],
    wordcount: {
      showParagraphs: false
    },
    filebrowserUploadUrl: window.Routing.generate('admin_harentius_blog_article_upload'),
    filebrowserBrowseUrl: window.Routing.generate('admin_harentius_blog_article_browse', {type: 'image'}),
    filebrowserAudioBrowseUrl: window.Routing.generate('admin_harentius_blog_article_browse', {type: 'audio'}),
  });
};
