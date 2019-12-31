const Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

const outputPath = process.env.OUTPUT_PATH || 'src/Resources/public/build/';
const publicPath = '/bundles/harentiusblog/build/';

const config = Encore
  .setOutputPath(outputPath)
  .setPublicPath(publicPath)
  .setManifestKeyPrefix('bundles/harentiusblog/')
  .cleanupOutputBeforeBuild()
  .addEntry('common', './src/Resources/js/common/index.js')
  .addEntry('article', './src/Resources/js/article/index.js')
  .addEntry('admin-article', './src/Resources/js/admin/article/index.js')
  .enableSassLoader()
  .enableReactPreset()
  .enableVersioning()
  .enableSingleRuntimeChunk()
  .enablePostCssLoader()
  .addPlugin(new CopyWebpackPlugin([
    { from: './node_modules/ckeditor4/config.js', to: 'ckeditor4/config.js' },
    { from: './node_modules/ckeditor4/styles.js', to: 'ckeditor4/styles.js' },
    { from: './node_modules/ckeditor4/contents.css', to: 'ckeditor4/contents.css' },
    { from: './node_modules/ckeditor4/skins/moono-lisa', to: 'ckeditor4/skins/moono-lisa' },
    { from: './node_modules/ckeditor4/lang', to: 'ckeditor4/lang' },
    { from: './node_modules/ckeditor4/plugins/image2', to: 'ckeditor4/plugins/image2' },
    { from: './node_modules/ckeditor4/plugins/widget', to: 'ckeditor4/plugins/widget' },
    { from: './node_modules/ckeditor4/plugins/codesnippet', to: 'ckeditor4/plugins/codesnippet' },
    { from: './node_modules/ckeditor4/plugins/justify', to: 'ckeditor4/plugins/justify' },
    { from: './node_modules/ckeditor4/plugins/scayt', to: 'ckeditor4/plugins/scayt' },
    { from: './node_modules/ckeditor4/plugins/tableselection', to: 'ckeditor4/plugins/tableselection' },
    { from: './node_modules/ckeditor4/plugins/wsc', to: 'ckeditor4/plugins/wsc' },
    { from: './node_modules/ckeditor4/plugins/dialog', to: 'ckeditor4/plugins/dialog' },
    { from: './node_modules/ckeditor-youtube-plugin/youtube', to: 'ckeditor4/plugins/youtube' },
    { from: './node_modules/ckeditor-wordcount-plugin/wordcount', to: 'ckeditor4/plugins/wordcount' },
    { from: './node_modules/ckeditor-more-plugin/wpmore', to: 'ckeditor4/plugins/wpmore' },
    { from: './node_modules/ckeditor-audio-plugin/audio', to: 'ckeditor4/plugins/audio' },
  ]))
  .getWebpackConfig()
;

module.exports = config;
