// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js

(function (app){
  'use strict';

  app.constant('GLOB', {
    host: 'http://vivufb.com/api/v1',
    name:'development',
    apiEndpoint:'http://dev.yoursite.com:10000/'
  });

  app.config(["$stateProvider", "$urlRouterProvider", function($stateProvider, $urlRouterProvider) {

    $stateProvider
      .state('app', {
        url: '/app',
        abstract: true,
        templateUrl: 'templates/app.html',
        controller: 'AppCtrl'
      })
      .state('app.feeds', {
        url: '/feeds',
        views: {
          'appContent': {
            templateUrl: 'templates/feeds.html',
            controller: 'FeedsCtrl'
          }
        }
      })
      .state('app.feed', {
        url: '/feed/:feedId',
        views: {
          'appContent': {
            templateUrl: 'templates/feed.html',
            controller: 'FeedCtrl'
          }
        }
      })
      .state('app.pages', {
        url: '/feeds',
        views: {
          'appContent': {
            templateUrl: 'templates/pages.html',
            controller: 'PagesCtrl'
          }
        }
      });
    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/app/feeds');

  }]);

  app.run(["$rootScope", "$ionicPlatform", "$ionicLoading", function($rootScope, $ionicPlatform, $ionicLoading) {

    $ionicPlatform.ready(function() {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      if (window.cordova && window.cordova.plugins.Keyboard) {
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      }
      if (window.StatusBar) {
        // org.apache.cordova.statusbar required
        StatusBar.styleDefault();
      }
    });

    $rootScope.showLoading = function (message) {
      $ionicLoading.show({
        template: message
      });
    };

    $rootScope.hideLoading = function () {
      $ionicLoading.hide();
    };

  }]);

}(angular.module('dlnFeed', [
  'ionic',
  'dlnFeed.appCtrl',
  'dlnFeed.feedsCtrl',

  'dlnFeed.directives',
  'dlnFeed.filters',
  'angularMoment'
])));





(function(app) {
  'use strict';

	app.directive('onLastRepeat', ['$timeout', function($timeout) {
		return {
			restrict: 'A',
			link: function (scope) {
				if (scope.$last === true) {
					$timeout(function () {
						scope.$emit('ngRepeatFinished');
					});
				}
			}
		};
	}]);

	app.directive('openExternal', ['$window', function () {
		return {
			restrict: 'E',
			scope: {
				url: '=',
				exit: '&',
				loadStart: '&',
				loadStop: '&',
				loadError: '&'
			},
			transclude: true,
			template:'<a href="javascript:void(0)" ng-click="openUrl()"><span ng-transclude></span></a>',
			controller: ['$scope', function($scope){
				var wrappedFunction = function(action){
					return function(){
						$scope.$apply(function(){
							action();
						});
					};
				};

				var inAppBrowser;
				$scope.openUrl = function(){
					console.log($scope.url);
					inAppBrowser = window.open($scope.url, '_system');
					if($scope.exit instanceof Function){
						inAppBrowser.addEventListener('exit', wrappedFunction($scope.exit));
					}
					if($scope.loadStart instanceof Function){
						inAppBrowser.addEventListener('loadstart', wrappedFunction($scope.loadStart));
					}
					if($scope.loadStop instanceof Function){
						inAppBrowser.addEventListener('loadstop', wrappedFunction($scope.loadStop));
					}
					if($scope.loadError instanceof Function){
						inAppBrowser.addEventListener('loaderror', wrappedFunction($scope.loadError));
					}
				};
				$scope.$on('$destroy', function(){
					if(inAppBrowser !== null){

						inAppBrowser.removeEventListener('exit', wrappedFunction($scope.exit));

						if($scope.exit){
							inAppBrowser.removeEventListener('exit', wrappedFunction($scope.exit));
						}
						if($scope.loadStart){
							inAppBrowser.removeEventListener('loadstart', wrappedFunction($scope.loadStart));
						}
						if($scope.loadStop){
							inAppBrowser.removeEventListener('loadstop', wrappedFunction($scope.loadStop));
						}
						if($scope.loadError){
							inAppBrowser.removeEventListener('loaderror', wrappedFunction($scope.loadError));
						}
					}

				});
			}]
		};
	}]);

}(angular.module('dlnFeed.directives', [])));

(function(app) {
  'use strict';

	app.filter('nFormater', function() {
		return function(input) {
			var num = parseFloat(input);
			if (num >= 1000000000) {
				return (num / 1000000000).toFixed(1) + 'g';
			}
			if (num >= 1000000) {
				return (num / 1000000).toFixed(1) + 'm';
			}
			if (num >= 1000) {
				return (num / 1000).toFixed(1) + 'k';
			}
			return num;
		};
	});

}(angular.module('dlnFeed.filters', [])));

/**
 * Created by root on 17/03/2015.
 */
(function (module) {
  'use strict';

  module.controller('AppCtrl', ['$rootScope', '$scope', function ($rootScope, $scope) {
    $rootScope = $rootScope;
    $scope = $scope;
  }]);

}(angular.module('dlnFeed.appCtrl', [])));

/**
 * Created by root on 17/03/2015.
 */
(function (module) {
  'use strict';

  module.controller('FeedsCtrl', ['$rootScope', '$http', '$scope', 'GLOB', function ($rootScope, $http, $scope, GLOB) {
    $scope.feeds = [];
    var page = 0;
    $scope.loading = false;

    $scope.getFeeds = function () {
      if ($scope.loading) {
        return;
      }

      $http.get(GLOB.host + '/feeds?page=' + page)
        .success(function(resp) {
          $scope.loading = false;
          if (resp.status === 'success') {
            angular.forEach(resp.data, function (item) {
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
        })
        .error(function(data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          $rootScope.hideLoading();
        });
    };

    $scope.getFeeds();

    $scope.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

  }]);

}(angular.module('dlnFeed.feedsCtrl', [])));
