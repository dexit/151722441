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
