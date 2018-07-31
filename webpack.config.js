const path = require('path');
module.exports = {
    entry: './resources/tz_assets/app.js',
    output: {
      filename: 'bundle.js',
      path: path.resolve(__dirname, 'public/tz_assets')
    },
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
                test: require.resolve('jquery'),
                use: [{
                   loader: 'expose-loader',
                   options: 'jQuery'
                },{
                   loader: 'expose-loader',
                   options: '$'
                }]
             }
        ]
    },
    devtool: "source-map"
  };