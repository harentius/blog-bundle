const Encore = require('@symfony/webpack-encore');

const outputPath = process.env.OUTPUT_PATH || 'src/Resources/public/build/';
const publicPath = '/bundles/harentiusblog/build/';

const config = Encore
  .setOutputPath(outputPath)
  .setPublicPath(publicPath)
  .setManifestKeyPrefix('bundles/harentiusblog/')
  .cleanupOutputBeforeBuild()
  .addEntry('common', './src/Resources/js/common/index.js')
  .addEntry('article', './src/Resources/js/article/index.js')
  .enableSassLoader()
  .enableVersioning()
  .enableSingleRuntimeChunk()
  .enablePostCssLoader()
  .getWebpackConfig()
;

module.exports = config;
