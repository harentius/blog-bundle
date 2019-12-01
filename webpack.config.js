const Encore = require('@symfony/webpack-encore');

const outputPath = process.env.OUTPUT_PATH || 'src/Resources/public/build/';

const config = Encore
  .setOutputPath(outputPath)
  .setPublicPath('/bundles/harentiusblog/build/')
  .setManifestKeyPrefix('bundles/harentiusblog/')
  .cleanupOutputBeforeBuild()
  .addEntry('common', './src/Resources/js/common.js')
  .addStyleEntry('login', './src/Resources/css/login.less')
  .addEntry('article-view', [
    './src/Resources/js/article.js',
  ])
  .addEntry('admin-article', './src/Resources/js/admin/article/index.js')
  .enableLessLoader()
  .enableSassLoader()
  .enableVersioning()
  .enableSingleRuntimeChunk()
  .getWebpackConfig()
;

if (!config.externals || (Array.isArray(config.externals) && config.externals.length === 0)) {
  config.externals = {};
}

Object.assign(config.externals, {
  Routing: 'Routing',
});

module.exports = config;
