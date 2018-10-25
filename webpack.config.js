const path = require('path');
module.exports = {
    entry: './resources/tz_assets/app.js',
    output: {
      filename: 'bundle.js',
      path: path.resolve(__dirname, 'public/tz_assets'),
      publicPath: "/tz_assets/"
    },
    mode: "production",
    module: {
        rules: [
            {
                test: /\.js$/,
                use: {
                    loader: 'babel-loader'
                },
                exclude: [
                    path.resolve(__dirname,"node_modules")
                ],
            },
            {
                test: /\.jsx$/,
                use: {
                    loader: 'babel-loader'
                }
            },
            {
                test: /\.(png|jpg|gif)$/i,
                use: [
                    {
                        loader: 'url-loader',
                        options: {
                            limit: 8192
                        }
                    }
                ]
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/,
                use: [
                    'file-loader'
                ]
            }
        ]
    },
    devtool: "source-map"
  };