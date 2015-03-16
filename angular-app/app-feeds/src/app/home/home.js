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
    module.controller('HomeController', function ($rootScope, $http, $scope) {
        // The top section of a controller should be lean and make it easy to see the "signature" of the controller
        //  at a glance.  All function definitions should be contained lower down.
		$scope.feeds = [];
		var page = 0;
		$scope.loading = false;

		$scope.getFeeds = function () {
			if (! $scope.loading) {
				$rootScope.showLoading();
				$scope.loading = true;
				var result = $http.get($rootScope.host + '/feeds?page=' + page).
					success(function(resp, status, headers, config) {
						$scope.loading = false;
						if (resp.status == 'success') {
							angular.forEach(resp.data, function (item, key) {
								var obj = {};
								obj.profile_src   = 'http://graph.facebook.com/' + item.page.fb_id + '/picture?type=small';
								obj.profile_name  = item.page.name;
								obj.created_at    = $scope.toTimeZone(item.created_at);
								if ($rootScope.checkPhonegapBrowser) {
									//obj.link      = item.link;
									obj.link      = item.app_link;
								} else {
									obj.link      = item.link;
								}
								obj.message       = item.message;
								obj.photo         = item.photo;
								obj.like_count    = item.like_count;
								obj.comment_count = item.comment_count;
								obj.share_count   = item.share_count;
								obj.type          = item.type;
								switch(item.type) {
									case 'photo':
										obj.font_type = 'fa fa-camera-retro';
										break;
									case 'video':
										obj.font_type = 'fa fa-play-circle';
										break;
									case 'link':
										obj.font_type = 'fa fa-unlink';
										break;
									case 'status':
										obj.font_type = 'fa fa-comment-o';
										break;
								}

								$scope.feeds.push(obj);
							});
						}
						$rootScope.hideLoading();
						page += 1;
					}).
					error(function(data, status, headers, config) {
						$scope.loading = false;
						console.log(data, status, headers, config);
						$rootScope.hideLoading();
					});
			}
		};
		$scope.getFeeds();

		$scope.toTimeZone = function (time) {
			return moment(time).add(7, 'hours');
		};

		$scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
			//window.$$('img.lazy').trigger('lazy');
			$('img.j-lazy').lazyload({
				effect : 'fadeIn',
				event : 'sporty'
			});
			$('img.j-lazy').trigger('appear');
		});

    });

// The name of the module, followed by its dependencies (at the bottom to facilitate enclosure)
}(angular.module("dlnAppFeed.home")));