/**
 * Each section of the site has its own module. It probably also has
 * submodules, though this boilerplate is too simple to demonstrate it. Within
 * 'src/app/home', however, could exist several additional folders representing
 * additional modules that would then be listed as dependencies of this one.
 * For example, a 'note' section could have the submodules 'note.create',
 * 'note.delete', 'note.edit', etc.
 *
 * Regardless, so long as dependencies are managed correctly, the build process
 * will automatically take take of the rest.
 */
(function(module) {

    // As you add controllers to a module and they grow in size, feel free to place them in their own files.
    //  Let each module grow organically, adding appropriate organization and sub-folders as needed.
    module.controller('HomeController', ['$rootScope', '$http', function ($rootScope, $http) {
        // The top section of a controller should be lean and make it easy to see the "signature" of the controller
        //  at a glance.  All function definitions should be contained lower down.
        var model = this;
		var page = 1;

        init();

        function init() {
			getFeeds();
        }

		function getFeeds() {
			$rootScope.showLoading();

			$http.get($rootScope.host + '/feeds?page=' + page).
				success(function(resp, status, headers, config) {
					if (resp.status == 'success') {
						model.feeds = resp.data;
					}
					$rootScope.hideLoading();
					page += 1;
				}).
				error(function(data, status, headers, config) {
					console.log(data, status, headers, config);
					$rootScope.hideLoading();
				});
		}

		function str_replace(url) {
			console.debug('http://www.facebook.com/' + url.replace('_', '/posts/'));
			return 'http://www.facebook.com/' + url.replace('_', '/posts/');
		}

    }]);

// The name of the module, followed by its dependencies (at the bottom to facilitate enclosure)
}(angular.module("dlnAppFeed.home")));