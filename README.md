# WP Starter Theme

A starter theme for WordPress with modern JavaScript and CSS tooling. This theme leverages Webpack, Sass, and modern JavaScript features to build a highly optimized, scalable WordPress theme.

## Features

- **Webpack 5** for module bundling and asset management.
- **Babel** for ES6+ JavaScript transpilation.
- **Sass** with `sass-loader` for compiling styles.
- **MiniCssExtractPlugin** for extracting and minifying CSS files.
- **TerserPlugin** for JavaScript minification.
- **CssMinimizerPlugin** for CSS minification.
- **Webpack Manifest Plugin** for generating a manifest file.
- **ESLint** and **Stylelint** integration for code quality.
- **Husky** and **lint-staged** for pre-commit hooks.

## Installation

To get started with this theme, follow these steps:

### Prerequisites

- [Node.js](https://nodejs.org/) (version 22 or later)
- [Composer](https://getcomposer.org/) (for managing PHP dependencies)

### Step 1: Clone the Repository

git clone https://github.com/your-username/wp-starter-theme.git
cd wp-starter-theme


### All Commands Included:

1. **Installation:**
   - `npm install` : Install Node.js dependencies.
   - `composer install` : Install PHP dependencies for WordPress.

2. **Development Commands:**
   - `npm run dev` : Start Webpack in development mode.
   - `npm run watch` : Watch for file changes during development.

3. **Linting Commands:**
   - `npm run lint:js` : Lint JavaScript files.
   - `npm run lint:js:fix` : Automatically fix JavaScript linting issues.
   - `npm run lint:scss` : Lint SCSS files.
   - `npm run lint:scss:fix` : Automatically fix SCSS linting issues.
   - `npm run phpcs` :  PHP files using PSR12 standard.
   - `npm run phpcbf` : php code beautifier and fixer.
   - `npm run lint` : Run all linting checks.
   - `npm run lint:fix` : Automatically fix all linting issues.

4. **Building Commands:**
   - `npm run build`  : Build the theme for production (optimized and minified).
