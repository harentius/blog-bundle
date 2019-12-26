const path = require('path');
const Encore = require('@symfony/webpack-encore');
const CKEditorWebpackPlugin = require('@ckeditor/ckeditor5-dev-webpack-plugin');
const { styles } = require('@ckeditor/ckeditor5-dev-utils');

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
  .enablePostCssLoader()
  .addPlugin(new CKEditorWebpackPlugin({
    language: 'en',
  }))
  .addRule({
    test: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
    loader: 'raw-loader',
  })
  .addRule({
    test: /src\/BlogBundle\/src\/Resources\/js\/admin\/ckeditor5\/readmore\/theme\/readmore\.svg$/,
    loader: 'raw-loader',
  })
  .configureLoaderRule('images', loader => {
    loader.exclude = [
      /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,
      /src\/BlogBundle\/src\/Resources\/js\/admin\/ckeditor5\/readmore\/theme\/readmore\.svg$/,
    ];
  })
  .configureLoaderRule('javascript', loader => {
    loader.include = [
      path.join(__dirname, './src/BlogBundle/src/Resources/js'),
      /\/node_modules\/@ckeditor/,
    ];
  })
  .addLoader({
    test: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/,
    loader: 'postcss-loader',
    options: styles.getPostCssConfig({
      themeImporter: {
        themePath: require.resolve('@ckeditor/ckeditor5-theme-lark'),
      },
    }),
  })
  .getWebpackConfig()
;

module.exports = config;
