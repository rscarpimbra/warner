const path                      = require('path')

const vPrefixPath               = "./public/assets/scripts/"

const { CleanWebpackPlugin}     = require('clean-webpack-plugin');


module.exports = {

    mode    : "development",

    performance: {

        hints: false,
    },

    entry: {

        _page_index             : ["idempotent-babel-polyfill",  vPrefixPath + "index.js"],
        _page_registration      : ["idempotent-babel-polyfill",  vPrefixPath + "registration.js"]


    },

    output: {
        path    : path.resolve(__dirname, './public/assets/scripts/bundle'),
        filename: "[name]_bundle.js",
    },

    module: {

        rules: [

            /* Babel Rules. */
            {
                test    : /\.js$/,
                exclude : '/node_modules',
                loader  : 'babel-loader'
            },
        ]
    },
  
    plugins: [
        new CleanWebpackPlugin(),
    ],

    watchOptions: {
        ignored: ['./node_modules']
    },

    watch: true
}