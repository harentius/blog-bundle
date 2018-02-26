const Encore = require('@symfony/webpack-encore');
const publicPath = '/bundles/harentiusblog/build/';

Encore
  .setOutputPath('src/Resources/public/build/')
  .setPublicPath(publicPath)
  .setManifestKeyPrefix('bundles/harentiusblog/')
  .cleanupOutputBeforeBuild()
  .createSharedEntry('common', [
    'js-cookie',
    'font-awesome/css/font-awesome.min.css',
    'bootstrap/js/collapse.js',
    './src/Resources/js/common.js',
    'bootstrap/dist/css/bootstrap.css',
    'ckeditor/plugins/codesnippet/lib/highlight/styles/default.css',
    './src/Resources/css/common.less',
    './src/Resources/css/twbs-extension.less',
    './src/Resources/css/main.less',
  ])
  .addStyleEntry('login', './src/Resources/css/login.less')
  .addEntry('article-view', [
    'bootstrap/js/tab.js',
    './src/Resources/js/article.js'
  ])
  .addEntry('post-admin', './src/Resources/js/admin/post.js')
  .addStyleEntry('admin', './src/Resources/css/admin.less')
  .enableLessLoader()
  .autoProvidejQuery()
  .enableVersioning()
  .configureDefinePlugin((options) => {
    options['process.env']['CKEDITOR_PLUGINS_PATH'] = JSON.stringify(`${publicPath}ckeditor-external-plugins.js`);
  })
;

module.exports = Encore.getWebpackConfig();
