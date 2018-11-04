let mix = require('laravel-mix');


mix.js('resources/assets/js/app.js', 'public/js');

mix.webpackConfig({
  module: {
    loaders: [{
      test: /\.styl$/,
      loader: 'css-loader!stylus-loader?paths=node_modules/bootstrap-stylus/stylus/'
    }]
  }
});