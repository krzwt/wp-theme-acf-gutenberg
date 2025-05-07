// Webpack config (ES6 Compatible) with full comments

import path from 'path';
import { fileURLToPath } from 'node:url';
import TerserPlugin from 'terser-webpack-plugin';
import MiniCssExtractPlugin from 'mini-css-extract-plugin';
import CssMinimizerPlugin from 'css-minimizer-webpack-plugin';
import { WebpackManifestPlugin } from 'webpack-manifest-plugin';
import { PurgeCSSPlugin } from 'purgecss-webpack-plugin';
import { globSync } from 'glob';

// Get current file path and directory
const filename = fileURLToPath(import.meta.url);
const dirname = path.dirname(filename);

// Detect if we're in development mode
/* eslint-disable no-undef */
const isDev = process?.argv?.includes('--watch') || false;
/* eslint-enable no-undef */

const jsFilename = isDev ? 'js/[name].dev.js' : 'js/[name].[contenthash].js';
const cssFilename = isDev ? 'css/[name].dev.css' : 'css/[name].[contenthash].css';

// Base plugins always applied
const plugins = [
    new MiniCssExtractPlugin({
        filename: cssFilename,
    }),
    new WebpackManifestPlugin({
        publicPath: '/',     // Ensure proper public path
        basePath: '',        // No double prefix
    }),
    // Uncomment PurgeCSS if you want to enable it
    // new PurgeCSSPlugin({
    //     paths: globSync(`${dirname}/**/*.php`),
    //     safelist: [], // Adjust safelist if needed
    //     defaultExtractor: (content) => content.match(/[\w-]+/g) || [],
    //     verbose: true,
    // }),
];

// Export Webpack config object
export default {
    mode: isDev ? 'development' : 'production',

    entry: {
        main: ['./sources/js/script.js', './sources/scss/style.scss'],
    },

    output: {
        path: path.resolve(dirname, 'assets'),
        filename: jsFilename,
        clean: true,
        publicPath: '/',
    },

    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            [
                                '@babel/preset-env',
                                {
                                    targets: {
                                        esmodules: true,
                                    },
                                    bugfixes: true,
                                    modules: false,
                                },
                            ],
                        ],
                        cacheDirectory: true,
                    },
                },
            },
            {
                test: /\.(scss|css)$/,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            publicPath: '../',
                        },
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1,
                            url: true,
                        },
                    },
                    'sass-loader',
                ],
            },
            {
                test: /\.(png|jpe?g|gif|svg|webp|avif)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[name][ext][query]', // ✅ images output to /assets/images/
                },
            },
            // Optional: fonts
            {
                test: /\.(woff(2)?|ttf|eot)$/,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[name][ext][query]',
                },
            },
        ],
    },

    resolve: {
        extensions: ['.scss', '.js'],
        alias: {
            '@scss': path.resolve(dirname, 'sources/scss'),
            '@js': path.resolve(dirname, 'sources/js'),
            '@img': path.resolve(dirname, 'sources/images'),
        },
    },

    plugins,

    optimization: {
        minimize: !isDev,
        minimizer: [
            new TerserPlugin({
                terserOptions: {
                    ecma: 2023,
                    compress: {
                        drop_console: !isDev,
                    },
                },
            }),
            new CssMinimizerPlugin(),
        ],
    },

    target: ['web', 'es2023'],

    devtool: 'cheap-module-source-map',

    watch: isDev,

    stats: {
        colors: true,
        modules: false,
        children: false,
        chunks: false,
        chunkModules: false,
    },

    performance: {
        hints: isDev ? false : 'warning',
        maxEntrypointSize: 512000,
        maxAssetSize: 512000,
    },
};