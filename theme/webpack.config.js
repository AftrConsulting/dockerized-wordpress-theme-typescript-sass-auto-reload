const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const Path = require('path');
const Chokidar = require('chokidar');

/**
 * Returns if is dev.
 */
 const isDev = () => !process.env.NODE_ENV;

module.exports = {
    context: __dirname,
    entry: [ './src/index.ts' ],
    output: {
        path: Path.resolve(__dirname, 'dist'),
        filename: '[name].js'
    },
	devtool: isDev() ? 'source-map' : false,
    resolve: {
        extensions: ['.js', '.ts', '.tsx', '.php'],
        modules: ['.', 'node_modules']
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/,
                exclude: /node_modules/,
                loader: 'ts-loader'
            },
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader'
                ]
            }
        ]
    },
    plugins: [
        new MiniCssExtractPlugin({ filename: '[name].css' }),
    ],
    mode: 'development',
    devServer: {
        before(app, server) {
            Chokidar.watch([
                './**/**/**/*.php'
            ]).on('all', function () {
                server.sockWrite(server.sockets, 'content-changed');
            })
        },
        contentBase: Path.join(__dirname, 'dist'),
        compress: true,
        port: 9000,
        historyApiFallback: true,
        host: '0.0.0.0',
        watchOptions: {
            ignored: /node_modules/
        }
    },
    optimization: {
        minimizer: [
            new TerserPlugin({
                parallel: true,
                terserOptions: {
                    output: {
                        comments: false
                    }
                }
            })
        ]
    }
};