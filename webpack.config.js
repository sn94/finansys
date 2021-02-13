const path = require('path');

module.exports = {

    entry: './assets/pnotify/pnotify.js',


    output: {

        filename: 'webpacktest.js',

        filename: '[name].bundle.js',
        path: path.resolve(__dirname, 'dist'),
    },
};