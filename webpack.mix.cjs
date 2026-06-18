const mix = require('laravel-mix');

// JS files
mix.js('public/assets/js/vendor.bundle.base.js', 'public/build')
   .js('public/assets/js/material.js', 'public/build')
   .js('public/assets/js/misc.js', 'public/build')
   .js('public/assets/js/dashboard.js', 'public/build')


// Versioning for cache-busting
   .version();
