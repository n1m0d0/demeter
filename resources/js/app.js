require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import jquery from "jquery";

window.jquery = jquery;

import toastr from "toastr";

window.toastr = toastr;

import './util/calendar';

import "zoom-vanilla.js/dist/zoom.css";
import "zoom-vanilla.js/dist/zoom-vanilla.min.js";