/* eslint-disable */
const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = {
    entry: [
        './assets/js/index.js',
        './assets/js/home.js'
    ],
    output: {
        path: path.resolve(__dirname, 'dist/js'),
        filename: 'scripts.js'
    },
    plugins: [
        new CleanWebpackPlugin(),
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            },
            {
                test: /\.scss$/i,
                use: [
                  // Creates `style` nodes from JS strings
                  'style-loader',
                  // Translates CSS into CommonJS
                  'css-loader',
                  // Compiles Sass to CSS
                  'sass-loader',
                ],
            },
            {
                test: /\.css$/,
                use: [
                  {
                    loader: 'file-loader',
                    options: {
                      name: 'css/[hash].[ext]'
                    }
                  },
                  'extract-loader',
                  'css-loader',
                  'postcss-loader'
                ],
                include: [/fonts/]
              },
          
              // Font files
              {
                test: /\.(woff|woff2|ttf|otf)$/,
                loader: 'file-loader',
                include: [/fonts/],
          
                options: {
                  name: '[hash].[ext]',
                  outputPath: 'css/',
                  publicPath: url => '../css/' + url
                }
              },
        ]
    }
}
