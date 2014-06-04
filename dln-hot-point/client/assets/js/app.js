angular.module('dlnApp', [])
	.run(['$rootScope', '$window', 'sessionService',
	function ($rootScope, $window, $sessionService) {
		$rootScope.session = $sessionService;
	}]);
angular.module();