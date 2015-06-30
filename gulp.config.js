/**
 * Created by Ryan on 30/06/2015.
 */

module.exports = function () {
    'use strict';

    var config = {
        temp: './.tmp/',

        // All JavaScript
        alljs: [
            './js/script.js',
            './*.js'
        ],
        client: './',
        index: './index.html',
        js: [
            './js/*.js'
        ],
        less: './css/**/style.css'
    };

    // config.getWiredepDefaultOptions = function () {
    //     return {
    //         bowerJson: config.bower.json,
    //         directory: config.bower.directory,
    //         ignorePath: config.bower.ignorePath
    //     };
    // };

    return config;
};
