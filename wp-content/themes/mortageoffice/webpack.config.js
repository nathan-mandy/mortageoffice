const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const { resolve } = require('path');

const app = resolve(`${process.cwd()}`);
const src = `${app}/src`;
const build = `${app}/build`;

const config = {
	...defaultConfig,
	target: 'web',
	resolve: {
		modules: ['node_modules', src],
	},
	entry: {
		main: [`${src}/main.js`, `${src}/main.scss`],
		admin: [`${src}/admin.js`, `${src}/admin.scss`],
	},
	output: {
		...defaultConfig.output,
		path: build,
	},
	plugins: [
		...defaultConfig.plugins,
		new (require('stylelint-webpack-plugin'))({
			customSyntax: 'postcss-scss',
			files: `${src}/styles`,
			fix: true,
		}),
	],
};

module.exports = config;
