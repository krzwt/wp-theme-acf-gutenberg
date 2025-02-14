/*
  Usage:
  1. npm install //To install all dev dependencies of package
  2. npm run dev //To start development and server for live preview
  3. npm run prod //To generate minified files for live server
*/

const { src, dest, watch, series, parallel } = require('gulp');
const del = require('del'); // For Cleaning build/dest for fresh export
const options = require("./config"); // Paths and other options from config.js

const sass = require('gulp-sass')(require('sass')); // For Compiling SASS files
const concat = require('gulp-concat'); // For Concatenating js,css files
const uglify = require('gulp-terser'); // To Minify JS files
const cleanCSS = require('gulp-clean-css'); // To Minify CSS files
const sourcemaps = require('gulp-sourcemaps'); // To show sourcemap
const purgecss = require('gulp-purgecss');

// ===== Dev tasks =====
function devStyles() {
  return src(`${options.paths.src.scss}/**/*.scss`)
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(concat({ path: 'style.min.css' }))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write('.'))
    .pipe(dest(options.paths.dest.css));
}

function devScripts() {
  return src([
    `${options.paths.src.js}/global/**/*.js`, // Include all JS files from global
    `${options.paths.src.js}/**/*.js`,        // Include all JS files from src
    `!${options.paths.src.js}/separate/**/*.js` // Exclude all JS files from the separate folder
  ])
  .pipe(concat({ path: 'scripts.js' })) // Concatenate all files into 'scripts.js'
  .pipe(dest(options.paths.dest.js)); // Output the concatenated file in the destination folder
}

function separateScripts() {
  return src(`${options.paths.src.js}/separate/**/*.js`)
    .pipe(uglify()) // Minify the JS files
    .pipe(dest(`${options.paths.dest.js}/separate/`)); // Output files to the separate folder in the destination
}

function watchFiles() {
  // Watch SCSS changes
  watch(`${options.paths.src.scss}/**/*.scss`, series(devStyles));

  // Watch all JS files except 'separate' folder for devScripts
  watch([
    `${options.paths.src.js}/global/**/*.js`,
    `${options.paths.src.js}/**/*.js`,
    `!${options.paths.src.js}/separate/**/*.js` // Exclude 'separate' folder
  ], series(devScripts));

  // Watch all JS files except 'separate' folder for prodScripts
  watch([
    `${options.paths.src.js}/global/**/*.js`,
    `${options.paths.src.js}/**/*.js`,
    `!${options.paths.src.js}/separate/**/*.js` // Exclude 'separate' folder
  ], series(prodScripts));

  // Watch 'separate' folder JS files for separateScripts task
  watch(`${options.paths.src.js}/separate/**/*.js`, series(separateScripts));

  console.log("Watching for Changes..\n");
}

function devClean() {
  console.log("Cleaning dest folder for fresh start.\n");
  return del([options.paths.dest.css, options.paths.dest.js]);
}

// ==== BUILD tasks =====
function prodStyles() {
  return src(`${options.paths.src.scss}/**/*.scss`)
    .pipe(sass().on('error', sass.logError))
    .pipe(concat({ path: 'style.min.css' }))
    .pipe(purgecss({
      content: ['*.php']
    }))
    .pipe(cleanCSS())
    .pipe(dest(options.paths.dest.css));
}

function prodScripts() {
  return src([
    `${options.paths.src.js}/global/**/*.js`,
    `${options.paths.src.js}/**/*.js`,
    `!${options.paths.src.js}/separate/**/*.js` // Exclude 'separate' folder
  ])
  .pipe(concat({ path: 'scripts.min.js' })) // Specify min.js filename
  .pipe(uglify()) // Minify the JS files
  .pipe(dest(options.paths.dest.js)); // Output the minified file
}

function prodClean() {
  console.log("Cleaning build folder for fresh start.\n");
  return del([options.paths.dest.css, options.paths.dest.js]);
}

function buildFinish(done) {
  console.log(`Production build is complete. Files are located at ${options.paths.dest.base}\n`);
  done();
}

exports.default = series(
  devClean, // Clean dest Folder
  parallel(devStyles, devScripts, prodScripts, separateScripts), // Run All tasks in parallel
  watchFiles // Watch for Live Changes
);

exports.prod = series(
  prodClean, // Clean Build Folder
  parallel(prodStyles, prodScripts), // Run All tasks in parallel
  buildFinish
);
