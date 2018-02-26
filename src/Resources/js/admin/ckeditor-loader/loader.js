window.CKEDITOR_BASEPATH = `${__webpack_public_path__}node_modules/ckeditor/`;

require(`!file-loader?context=${__dirname}&outputPath=node_modules/ckeditor/&name=[path][name].[ext]!./config.js`);
require(`!file-loader?context=${__dirname}&outputPath=node_modules/ckeditor/&name=[name].[ext]!ckeditor/contents.css`);
require(`!file-loader?context=${__dirname}&outputPath=node_modules/ckeditor/&name=[path][name].[ext]!./styles.js`);

require.context(
  '!file-loader?name=[path][name].[ext]!ckeditor/plugins/',
  true,
  /^\.\/((scayt|tableselection|wsc|justify|div|codesnippet|image2|link|widget)(\/(?!lang\/)[^/]+)*)?[^/]*\.((?!md).)*$/i
);
require.context(
  '!file-loader?name=[path][name].[ext]!ckeditor/plugins/',
  true,
  /^\.\/(scayt|tableselection|wsc|justify|div|codesnippet|image2|link|widget)\/(.*\/)*lang\/(en|ru)\.js$/
);

require.context(
  '!file-loader?name=[path][name].[ext]!ckeditor/lang',
  true,
  /(en|ru)\.js/
);
require.context(
  '!file-loader?name=[path][name].[ext]!ckeditor/skins/moono-lisa',
  true,
  /\.((?!md).)*$/i
);
