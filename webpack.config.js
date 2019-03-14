// ----------------
// Modules
// ----------------

const path = require('path');
const webpack = require('webpack');
const VueLoaderPlugin = require('vue-loader/lib/plugin');



// ----------------
// Common
// ----------------

const Common = {

    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.css$/,
                use: [
                    'vue-style-loader',
                    'css-loader'
                ]
            }
        ]
    },

    plugins: [
        new VueLoaderPlugin(),
        new webpack.DefinePlugin({
            API_ORIGIN: JSON.stringify('https://altaviasumis.projects.dynconnect.com/_')
        })
    ],

    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src/')
        }
    },

    entry: [
        './src/app.js'
    ]

};



// ----------------
// Development
// ----------------

const Dev = {

    mode: 'development',

    devServer: {
        contentBase: path.join(__dirname, 'dist'),
        compress: true,
        port: 9000
    }

};



// ----------------
// Production
// ----------------

const Prod = {

    mode: 'production'

};



// ----------------
// Exports
// ----------------

module.exports = env => {

    switch (env) {
        case 'dev': return Object.assign(Common, Dev);
        case 'prod': return Object.assign(Common, Prod);
    }

};
