require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import jquery from "jquery";

window.jquery = jquery;

import './util/calendar';