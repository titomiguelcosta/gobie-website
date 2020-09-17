/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('octicons');
require('../css/app.css');
require('jquery.json-viewer/json-viewer/jquery.json-viewer.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');

const $ = require('jquery');
global.$ = global.jQuery = $;
global.gobie = {};

require('bootstrap');
require('chart.js/dist/Chart.bundle');
require('jquery.json-viewer/json-viewer/jquery.json-viewer');
require('./pusher.min.js');
require('react');
require('./components/motto');

console.log('Hello from Gobie!');
