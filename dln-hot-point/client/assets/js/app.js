angular.module('DLNApp', [])
	.run(['$rootScope', '$window', 'sessionService',
	function ($rootScope, $window, $sessionService) {
		$rootScope.session = sessionService;
	}]);