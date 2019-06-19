// ----------------
// Modules
// ----------------

const path = require('path');
const webpack = require('webpack');
const VueLoaderPlugin = require('vue-loader/lib/plugin');



// ------------------
// Constants
// ------------------

const API_ORIGIN = 'https://admin.sumislogistics.nl/_';
const EMAIL = 'dmitriy@dmitriy.com';
const PASSWORD = 'test';



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
            },
            {
                test: /\.svg$/,
                loader: 'vue-svg-loader'
            },
        ]
    },

    plugins: [
        new VueLoaderPlugin(),
        new webpack.DefinePlugin({
            API_ORIGIN: JSON.stringify(API_ORIGIN)
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
    },

    plugins: [
        ...Common.plugins,
        new webpack.DefinePlugin({
            EMAIL: JSON.stringify(EMAIL),
            PASSWORD: JSON.stringify(PASSWORD),
        })
    ]

};



// ----------------
// Production
// ----------------

const Prod = {

    mode: 'production',

    plugins: [
        ...Common.plugins,
        new webpack.DefinePlugin({
            EMAIL: JSON.stringify(''),
            PASSWORD: JSON.stringify(''),
        })
    ]

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
