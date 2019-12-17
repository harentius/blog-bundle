const Encore = require('@symfony/webpack-encore');

const outputPath = process.env.OUTPUT_PATH || 'src/Resources/public/build/';

const config = Encore
  .setOutputPath(outputPath)
  .setPublicPath('/bundles/harentiusblog/build/')
  .setManifestKeyPrefix('bundles/harentiusblog/')
  .cleanupOutputBeforeBuild()
  .addEntry('common', './src/Resources/js/common/index.js')
  .addEntry('article', './src/Resources/js/article/index.js')
  .addEntry('admin-article', './src/Resources/js/admin/article/index.js')
  .enableSassLoader()
  .enableReactPreset()
  .enableVersioning()
  .enableSingleRuntimeChunk()
  .getWebpackConfig()
;

module.exports = config;
