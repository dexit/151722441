module.exports = {
	root: '.',
	suites: ['app/test'],
	plugins: {
		local: {
			browsers: ['chrome', 'firefox']
		}
	}
};
